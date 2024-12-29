<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
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
$percentage = $plan->getProducedPercentage();
?>
<div class="plan-view">
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <p>
                <?= Html::a('<i class="fa fa-pen"></i> Изменить', ['update-plan', 'id' => $plan->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-plus"></i> Создать ежедневный отчет', ['create-report', 'id' => $plan->factory->id], ['class' => 'btn btn-success']) ?>
            </p>
            <b>План выполнен на</b>
            <div class="progress" style="height:25px">
                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:<?=$percentage?>%;height:25px"><?=$percentage?>%</div>
            </div>
            <br>
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
                            <th scope="row"><b>Произведено товара на сумму</b></th>
                            <td><?= MainHelper::priceFormat($plan->amount - $plan->profit) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Прибыль</b></th>
                            <td><?= MainHelper::priceFormat($plan->profit) ?></td>
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
                            <th scope="row"><b>Произведено товара на сумму</b></th>
                            <td><?= MainHelper::priceFormat(($plan->amount - $plan->profit) / $workdays) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><b>Прибыль</b></th>
                            <td><?= MainHelper::priceFormat($plan->profit / $workdays) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <h4>Отчеты</h4>
            <?= $this->render('../report/_grid-view', [
                'searchModel' => $reportSearchModel,
                'dataProvider' => $reportDataProvider,
                'hasFactory' => false
            ]); ?>
        </div>
    </div>
</div>
