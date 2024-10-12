<?php

/* @var $this yii\web\View */
/* @var $factory app\models\Factory */
/* @var $report app\models\Report */
/* @var $products app\models\Product[] */

$this->title = "Создать отчет";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $factory->name, 'url' => ['view', 'id' => $factory->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-create">
    <?= $this->render('_form_report', [
        'factory' => $factory,
        'report' => $report,
        'products' => $products
    ]) ?>
</div>
