<?php

use app\helpers\MainHelper;
use app\models\Factory;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\search\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
$states = MainHelper::TASK_STATES;
?>
<div class="task-index">
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function ($task, $key, $index, $grid) {
                    $class = '';
                    if ($task->status == 2) {
                        $class = 'table-danger';
                    } elseif ($task->status == 0) {
                        $class = 'table-warning';
                    }
                    return [
                        'onclick' => 'window.location.href = "' . Url::to(['/factory/view-task', 'id' => $task->id]) . '"',
                        'style' => 'cursor: pointer;',
                        'class' => $class
                    ];
                },
                'tableOptions' => [
                    'class' => 'footable table table-striped table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'factory_id',
                        'value' => function ($model) {
                            return $model->factory->name;
                        },
                        'filter' => ArrayHelper::map(Factory::find()->all(), 'id', 'name'),
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите']
                    ],
                    [
                        'attribute' => 'month',
                        'value' => 'month',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'month',
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm',
                                'todayHighlight' => true,
                                'daysOfWeekDisabled' => [0]
                            ],
                            'options' => ['placeholder' => 'Введите месяц ...']
                        ])
                    ],
                    [
                        'attribute' => 'start_date',
                        'value' => 'start_date',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'start_date',
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'daysOfWeekDisabled' => [0]
                            ]
                        ])
                    ],
                    [
                        'attribute' => 'end_date',
                        'value' => 'end_date',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'end_date',
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'daysOfWeekDisabled' => [0]
                            ]
                        ])
                    ],
                    'description:ntext',
                    [
                        'attribute' => 'status',
                        'filter' => $states,
                        'value' => function ($task) use ($states) {
                            return $states[$task->status] ?? $task->status;
                        },
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите'],
                    ],
                    'reason:ntext',
                    //'created_at',
                    //'updated_at',
                ],
            ]); ?>
        </div>
    </div>
</div>
