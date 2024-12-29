<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Task $task */

$this->title = "Задача за $task->month";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $task->factory->name, 'url' => ['view', 'id' => $task->factory->id]];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$states = MainHelper::TASK_STATES
?>
<div class="task-view">
    <div class="card">
        <div class="card-body">
            <?php if (in_array($task->status, [0, 2]) || Yii::$app->user->can('admin')) : ?>
                <?= Html::a('<i class="fa fa-pen"></i> Изменить', ['update-task', 'id' => $task->id], ['class' => 'btn btn-primary']) ?>
            <?php endif ?>
            <?php if ($task->status == 0 && Yii::$app->user->can('admin')) : ?>
                <?= Html::a('<i class="fa fa-check"></i> Подтвердить', ['confirm-task', 'id' => $task->id], [
                    'class' => 'btn btn-info',
                    'data' => [
                        'confirm' => "Вы уверены, что хотите подтвердить эту задачу?",
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
            <?php if ($task->status == 0 && Yii::$app->user->can('admin')) : ?>
                <?= Html::a('<i class="fa fa-ban"></i> Отклонить', ['reject-task', 'id' => $task->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => "Вы уверены, что хотите отклонить эту задачу?",
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
            <?php
            $attributes = [
//                    'id',
                [
                    'attribute' => 'factory_id',
                    'value' => function ($model) {
                        return $model->factory->name;
                    }
                ],
                'month',
                'start_date',
                'end_date',
                'description:ntext',
                [
                    'attribute' => 'status',
                    'value' => function ($model) use ($states) {
                        return $states[$model->status] ?? $model->status;
                    }
                ],
                'created_at',
                'updated_at',
            ];
            if ($task->reason) {
                $attributes['reason'] = $task->reason;
            }
            ?>
            <?= DetailView::widget([
                'model' => $task,
                'attributes' => $attributes,
            ]) ?>
        </div>
    </div>
</div>
