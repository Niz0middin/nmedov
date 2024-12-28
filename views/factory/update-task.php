<?php

/** @var yii\web\View $this */
/** @var app\models\Task $task */

$this->title = 'Изменить';
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $task->factory->name, 'url' => ['view', 'id' => $task->factory->id]];
$this->params['breadcrumbs'][] = ['label' => "Задача за $task->month", 'url' => ['view-task', 'id' => $task->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="task-update">
    <?= $this->render('_form_task', [
        'task' => $task,
    ]) ?>
</div>
