<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Report $report */
/* @var $reportProducts app\models\ReportProduct[] */

$this->title = "Ежедневный отчет";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $report->factory->name, 'url' => ['view', 'id' => $report->factory->id]];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$states = MainHelper::STATES
?>
<div class="report-view">
    <div class="card">
        <div class="card-body">
            <?php if (!empty($reportProducts)): ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Unit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reportProducts as $reportProduct): ?>
                        <tr>
                            <td><?= Html::encode($reportProduct->product->name) ?></td>
                            <td><?= Html::encode($reportProduct->amount) ?></td>
                            <td><?= Html::encode($reportProduct->product->unit) ?></td>
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
