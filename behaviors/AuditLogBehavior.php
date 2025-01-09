<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\AuditLog;

class AuditLogBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'logCreate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'logUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'logDelete',
        ];
    }

    public function logCreate($event)
    {
        $this->log('create', $event->sender);
    }

    public function logUpdate($event)
    {
        $changedAttributes = $event->changedAttributes; // Original values before update
        $this->log('update', $event->sender, $changedAttributes);
    }

    public function logDelete($event)
    {
        $this->log('delete', $event->sender);
    }

    protected function log($action, $model, $changedData = null)
    {
        $auditLog = new AuditLog();
        $auditLog->table_name = $model->tableName();
        $auditLog->row_id = $model->primaryKey;
        $auditLog->action = $action;
        $auditLog->changed_data = $changedData ? json_encode($changedData) : null;
        $auditLog->created_by = Yii::$app->user->id ?? null; // Logged-in user
        $auditLog->save(false);
    }
}
