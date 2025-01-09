<?php

use app\helpers\MainHelper;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Factory $factory */
/** @var app\models\search\PlanSearch $planSearchModel */
/** @var yii\data\ActiveDataProvider $planDataProvider */
/** @var app\models\search\TaskSearch $taskSearchModel */
/** @var yii\data\ActiveDataProvider $taskDataProvider */
/** @var app\models\search\StorageViewSearch $storageSearchModel */
/** @var yii\data\ActiveDataProvider $storageDataProvider */

$this->title = $factory->name;
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$states = MainHelper::TASK_STATES;
?>
<div class="factory-view">
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <p>
                <!--                        --><?php //= Html::a('<i class="fa fa-pen"></i> Изменить', ['update', 'id' => $factory->id], ['class' => 'btn btn-primary']) ?>
                <!--                        --><?php //= Html::a('<i class="fa fa-trash"></i> Удалить', ['delete', 'id' => $report->id], [
                //                            'class' => 'btn btn-danger',
                //                            'data' => [
                //                                'confirm' => 'Are you sure you want to delete this item?',
                //                                'method' => 'post',
                //                            ],
                //                        ]) ?>
                <?= Html::a('<i class="fa fa-chart-line"></i> Поставить ежемесячный план', ['create-plan', 'id' => $factory->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-tasks"></i> Добавить задачу', ['create-task', 'id' => $factory->id], ['class' => 'btn btn-success']) ?>
                <?= Html::a('<i class="fa fa-warehouse"></i> Добавить остаток по складу', ['create-storage', 'id' => $factory->id], ['class' => 'btn btn-info']) ?>
            </p>
            <h4>Планы</h4>
            <?= GridView::widget([
                'dataProvider' => $planDataProvider,
                'filterModel' => $planSearchModel,
                'rowOptions' => function ($plan, $key, $index, $grid) {
                    return [
                        'onclick' => 'window.location.href = "' . Url::to(['view-plan', 'id' => $plan->id]) . '"',
                        'style' => 'cursor: pointer;'
                    ];
                },
                'tableOptions' => [
                    'class' => 'footable table table-striped table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                            'id',
//                            'factory_id',
                    [
                        'attribute' => 'month',
                        'value' => 'month',
                        'filter' => DatePicker::widget([
                            'model' => $planSearchModel,
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
                        'attribute' => 'amount',
                        'value' => function ($model) {
                            return MainHelper::priceFormat($model->amount);
                        },
                    ],
                    [
                        'attribute' => 'profit',
                        'value' => function ($model) {
                            return MainHelper::priceFormat($model->profit);
                        },
                    ],
                    [
                        'attribute' => 'sht_amount',
                        'value' => function ($model) {
                            return MainHelper::amountFormat($model->sht_amount);
                        },
                    ],
                    [
                        'attribute' => 'kg_amount',
                        'value' => function ($model) {
                            return MainHelper::amountFormat($model->kg_amount);
                        },
                    ],
                    [
                        'attribute' => 'workdays',
                        'label' => 'Рабочие дни',
                        'value' => function ($model) {
                            return MainHelper::getDaysWithoutSundays($model->month);
                        },
                    ],
                    //'status',
                    //'created_at',
                    //'updated_at',
                ],
            ]); ?>
            <h4>Задачи</h4>
            <?= GridView::widget([
                'dataProvider' => $taskDataProvider,
                'filterModel' => $taskSearchModel,
                'rowOptions' => function ($task, $key, $index, $grid) {
                    $class = '';
                    if ($task->status == 2) {
                        $class = 'table-danger';
                    } elseif ($task->status == 0) {
                        $class = 'table-warning';
                    }
                    return [
                        'onclick' => 'window.location.href = "' . Url::to(['view-task', 'id' => $task->id]) . '"',
                        'style' => 'cursor: pointer;',
                        'class' => $class
                    ];
                },
                'tableOptions' => [
                    'class' => 'footable table table-striped table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                            'id',
//                            'factory_id',
                    [
                        'attribute' => 'month',
                        'value' => 'month',
                        'filter' => DatePicker::widget([
                            'model' => $taskSearchModel,
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
                            'model' => $taskSearchModel,
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
                            'model' => $taskSearchModel,
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
            <h4>Остатки на складе</h4>
            <?= $this->render('../storage/_grid-view', [
                'searchModel' => $storageSearchModel,
                'dataProvider' => $storageDataProvider,
                'hasFactory' => false
            ]); ?>
        </div>
    </div>
</div>
