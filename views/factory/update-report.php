<?php

/* @var $this yii\web\View */
/* @var $factory app\models\Factory */
/* @var $report app\models\Report */
/* @var $products app\models\Product[] */
/* @var $reportProducts app\models\ReportProduct[] */

$this->title = "Изменить";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $factory->name, 'url' => ['view', 'id' => $factory->id]];
$this->params['breadcrumbs'][] = ['label' => "План за {$report->plan->month}", 'url' => ['view-plan', 'id' => $report->plan->id]];
$this->params['breadcrumbs'][] = ['label' => "Отчет за $report->date", 'url' => ['view-report', 'id' => $report->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-update">
    <?= $this->render('_form_report', [
        'factory' => $factory,
        'report' => $report,
        'products' => $products,
        'reportProducts' => $reportProducts
    ]) ?>
</div>
