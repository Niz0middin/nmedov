<?php

use app\helpers\MainHelper;
use app\models\Factory;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\search\ReportViewSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Отчеты';
$this->params['breadcrumbs'][] = $this->title;
$states = MainHelper::REPORT_STATES;
$models = $dataProvider->getModels();
?>
<style>
    tfoot {
        font-weight: bold;
    }
</style>
<div class="report-view-index">
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'showFooter' => true,
                'rowOptions' => function ($model) {
                    $class = '';
                    if ($model->status == 0) {
                        $class = 'table-warning';
                    }
                    return [
                        'style' => 'cursor: pointer;',
                        'class' => $class
                    ];
                },
                'tableOptions' => [
                    'class' => 'footable table table-striped table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id',
                    [
                        'attribute' => 'factory_id',
                        'value' => function ($model) {
                            return $model->factory->name;
                        },
                        'filter' => ArrayHelper::map(Factory::find()->all(), 'id', 'name'),
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите']
                    ],
                    [
                        'attribute' => 'date',
                        'value' => 'date',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'date',
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'daysOfWeekDisabled' => [0]
                            ],
                            'options' => ['placeholder' => 'Введите дату ...'],
                        ]),
                        'footer' => 'Общий:'
                    ],
                    [
                        'attribute' => 'income',
                        'value' => function ($report) {
                            return MainHelper::priceFormat($report->income);
                        },
                        'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'income')))
                    ],
                    [
                        'attribute' => 'cost_price',
                        'value' => function ($report) {
                            return MainHelper::priceFormat($report->cost_price);
                        },
                        'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'cost_price')))
                    ],
                    [
                        'attribute' => 'expense',
                        'value' => function ($report) {
                            $expense_description = $report->expense_description ? " ($report->expense_description)" : null;
                            return MainHelper::priceFormat($report->expense) . $expense_description;
                        },
                        'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'expense')))
                    ],
                    [
                        'attribute' => 'profit',
                        'value' => function ($report) {
                            return MainHelper::priceFormat($report->profit);
                        },
                        'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'profit')))
                    ],
                    [
                        'attribute' => 'sht',
                        'value' => function ($report) {
                            return MainHelper::priceFormat($report->sht);
                        },
                        'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'sht')))
                    ],
                    [
                        'attribute' => 'kg',
                        'value' => function ($report) {
                            return MainHelper::priceFormat($report->kg);
                        },
                        'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'kg')))
                    ],
                    [
                        'attribute' => 'cash_amount',
                        'value' => function ($report) {
                            return MainHelper::priceFormat($report->cash_amount);
                        },
                        'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'cash_amount')))
                    ],
                    [
                        'attribute' => 'transfer_amount',
                        'value' => function ($report) {
                            return MainHelper::priceFormat($report->transfer_amount);
                        },
                        'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'transfer_amount')))
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => $states,
                        'value' => function ($report) use ($states) {
                            return $states[$report->status] ?? $report->status;
                        },
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите'],
                    ],
                    //'created_at',
                    //'updated_at',
                ],
            ]); ?>
        </div>
    </div>
</div>
