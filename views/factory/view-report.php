<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Report $report */
/** @var $reportProducts app\models\ReportProduct[] */

$this->title = "Отчет за $report->date";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $report->factory->name, 'url' => ['view', 'id' => $report->factory->id]];
if (isset($report->plan->month)) {
    $this->params['breadcrumbs'][] = ['label' => "План за {$report->plan->month}", 'url' => ['view-plan', 'id' => $report->plan->id]];
}
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="report-view">
    <div class="card">
        <div class="card-body">
            <?php if ($report->status == 0 || Yii::$app->user->can('admin') || Yii::$app->user->can('superadmin')) : ?>
                <?= Html::a('<i class="fa fa-pen"></i> Изменить', ['update-report', 'id' => $report->id], ['class' => 'btn btn-primary']) ?>
            <?php endif ?>
            <?php if ($report->status == 0) : ?>
                <?= Html::a('<i class="fa fa-check"></i> Подтвердить', ['confirm-report', 'id' => $report->id], [
                    'class' => 'btn btn-info',
                    'data' => [
                        'confirm' => "Вы уверены, что хотите подтвердить этот отчет?\nПосле подтверждения вы не сможете его изменить",
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
            <?= Html::a('<i class="fa fa-file-excel"></i> Загрузить как Excel', ['excel-report', 'id' => $report->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'method' => 'post',
                ]
            ]) ?>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Расходы</th>
                    <th>Комментарий к расходам</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= MainHelper::priceFormat($report->expense) ?></td>
                    <td><?= $report->expense_description ?></td>
                </tr>
                </tbody>
            </table>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Приход наличных средств</th>
                    <th>Приход по перечислению</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= MainHelper::priceFormat($report->cash_amount) ?></td>
                    <td><?= MainHelper::priceFormat($report->transfer_amount) ?></td>
                </tr>
                </tbody>
            </table>
            <br>
            <?php if (!empty($reportProducts)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Продукт</th>
                        <th>Количество</th>
                        <th>Ед. изм.</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reportProducts as $reportProduct): ?>
                        <tr>
                            <td><?= $reportProduct->product->name ?></td>
                            <td><?= MainHelper::amountFormat($reportProduct->amount) ?></td>
                            <td><?= $reportProduct->product->unit ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Отчеты по этому заводу не найдены.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
