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

$this->title = $factory->name;
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

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
                                'format' => 'yyyy-mm-dd',
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
        </div>
    </div>
</div>
