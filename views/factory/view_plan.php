<?php

use app\helpers\MainHelper;
use kartik\widgets\DatePicker;
use yii\bootstrap4\LinkPager;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Plan $plan */
/** @var app\models\search\ReportSearch $reportSearchModel */
/** @var yii\data\ActiveDataProvider $reportDataProvider */

$this->title = "План за $plan->month";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $plan->factory->name, 'url' => ['view', 'id' => $plan->factory->id]];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$states = MainHelper::REPORT_STATES;
$kg_amount = MainHelper::amountFormat($plan->kg_amount);
$sht_amount = MainHelper::amountFormat($plan->sht_amount);
?>
<div class="plan-view">
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <p>
                <?= Html::a('<i class="fa fa-pen"></i> Изменить', ['update-plan', 'id' => $plan->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-plus"></i> Создать ежедневный отчет', ['create-report', 'id' => $plan->factory->id], ['class' => 'btn btn-success']) ?>
            </p>
            <h5>
                <b>Рабочие дни: </b><?= MainHelper::getDaysWithoutSundays($plan->month) ?><br>
                <b>Реализация: </b><?= "$kg_amount кг, $sht_amount шт" ?><br>
                <b>Приход: </b><?= MainHelper::priceFormat($plan->amount) ?><br>
                <b>Прибыль: </b><?= MainHelper::priceFormat($plan->profit) ?><br>
                <b>Расход: </b><?= MainHelper::priceFormat($plan->amount - $plan->profit) ?><br>
                <br>
            </h5>
            <h4>Отчеты</h4>
            <?= GridView::widget([
                'dataProvider' => $reportDataProvider,
                'filterModel' => $reportSearchModel,
                'rowOptions' => function ($report, $key, $index, $grid) {
                    $class = '';
                    if ($report->status == 0) {
                        $class = 'table-warning';
                    }
                    return [
                        'id' => $report->id,
                        'onclick' => 'window.location.href = "' . Url::to(['view-report', 'id' => $report->id]) . '"',
                        'style' => 'cursor: pointer;',
                        'class' => $class
                    ];
                },
                'tableOptions' => [
                    'class' => 'footable table table-striped table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
                    [
                        'attribute' => 'date',
                        'value' => 'date',
                        'filter' => DatePicker::widget([
                            'model' => $reportSearchModel,
                            'attribute' => 'date',
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'daysOfWeekDisabled' => [0]
                            ],
                            'options' => ['placeholder' => 'Введите дату ...'],
                        ])
                    ],
                    [
                        'attribute' => 'approximate',
                        'label' => 'Приблизительный дневной план',
                        'format' => 'html',
                        'value' => function ($model) use ($plan) {
                            $work_days = MainHelper::getDaysWithoutSundays($plan->month);
                            $profit = MainHelper::priceFormat($plan->profit/$work_days);
                            $income = MainHelper::priceFormat($plan->amount/$work_days);
                            $expense = MainHelper::priceFormat(($plan->amount - $plan->profit)/$work_days);
                            $kg = MainHelper::amountFormat($plan->kg_amount/$work_days);
                            $sht = MainHelper::amountFormat($plan->sht_amount/$work_days);
                            return "
                              <b>Реализация:</b> $kg кг, $sht 	шт<br>
                              <b>Приход:</b> $income<br>
                              <b>Прибыль:</b> $profit<br>
                              <b>Расход:</b> $expense<br>
                            ";
                        }
                    ],
                    [
                        'attribute' => 'overall',
                        'label' => 'Производен',
                        'format' => 'html',
                        'value' => function ($model) {
                            $sht = $kg = $income = $expense = 0;
                            foreach ($model->reportProducts as $reportProduct) {
                                $amount = $reportProduct->amount;
                                $product = $reportProduct->product;
                                $income += ($product->price * $amount);
                                $expense += ($product->cost_price * $amount);
                                if ($product->unit == 'шт') {
                                    $sht += $amount;
                                } else {
                                    $kg += $amount;
                                }
                            }
                            $profit = MainHelper::priceFormat($income - $expense);
                            $income = MainHelper::priceFormat($income);
                            $expense = MainHelper::priceFormat($expense);
                            $kg = MainHelper::amountFormat($kg);
                            $sht = MainHelper::amountFormat($sht);
                            return "
                              <b>Реализация:</b> $kg кг, $sht 	шт<br>
                              <b>Приход:</b> $income<br>
                              <b>Прибыль:</b> $profit<br>
                              <b>Расход:</b> $expense<br>
                            ";
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => $states,
                        'value' => function ($model) use ($states) {
                            return $states[$model->status] ?? $model->status;
                        },
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'value' => 'created_at',
                        'filter' => DatePicker::widget([
                            'model' => $reportSearchModel,
                            'attribute' => 'created_at',
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'daysOfWeekDisabled' => [0]
                            ],
                            'options' => ['placeholder' => 'Введите дату ...'],
                        ])
                    ],
                    //'updated_at',
                ],
                'pager' => [
                    'class' => LinkPager::class
                ]
            ]); ?>
        </div>
    </div>
</div>
