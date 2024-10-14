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
$workdays = MainHelper::getDaysWithoutSundays($plan->month);
$daily_kg_amount = MainHelper::amountFormat($plan->kg_amount / $workdays);
$daily_sht_amount = MainHelper::amountFormat($plan->sht_amount / $workdays);
?>
<div class="plan-view">
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <p>
                <?= Html::a('<i class="fa fa-pen"></i> Изменить', ['update-plan', 'id' => $plan->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-plus"></i> Создать ежедневный отчет', ['create-report', 'id' => $plan->factory->id], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="row">
                <div class="col">
                    <table class="table table-bordered table-striped table-sm">
                        <tbody>
                        <tr>
                            <th scope="row"><b>Рабочие дни</b></th>
                            <td><?= $workdays ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Реализация</b></th>
                            <td><?= "$kg_amount кг, $sht_amount шт" ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Приход</b></th>
                            <td><?= MainHelper::priceFormat($plan->amount) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Прибыль</b></th>
                            <td><?= MainHelper::priceFormat($plan->profit) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Произведено товара на сумму</b></th>
                            <td><?= MainHelper::priceFormat($plan->amount - $plan->profit) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col">
                    <table class="table table-bordered table-striped table-sm">
                        <tbody>
                        <tr>
                            <th scope="row"><b>За день</b></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Реализация</b></th>
                            <td><?= "$daily_kg_amount кг, $daily_sht_amount шт" ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Приход</b></th>
                            <td><?= MainHelper::priceFormat($plan->amount / $workdays) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Прибыль</b></th>
                            <td><?= MainHelper::priceFormat($plan->profit / $workdays) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Произведено товара на сумму</b></th>
                            <td><?= MainHelper::priceFormat(($plan->amount - $plan->profit) / $workdays) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <h4>Отчеты</h4>
            <?= GridView::widget([
                'dataProvider' => $reportDataProvider,
                'filterModel' => $reportSearchModel,
                'rowOptions' => function ($report, $key, $index, $grid) {
                    $class = 'table-default';
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
                        'attribute' => 'overall',
                        'label' => 'Общий',
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
                              <b>Произведено товара на сумму:</b> $expense<br>
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
