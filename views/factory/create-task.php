<?php

/** @var yii\web\View $this */
/** @var app\models\Task $task */
/** @var app\models\Factory $factory */

$this->title = 'Создать задачу';
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $factory->name, 'url' => ['view', 'id' => $factory->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">
    <?= $this->render('_form-task', [
        'task' => $task,
    ]) ?>
</div>
