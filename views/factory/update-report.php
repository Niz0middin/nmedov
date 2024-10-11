<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $factory app\models\Factory */
/* @var $report app\models\Report */
/* @var $products app\models\Product[] */
/* @var $reportProducts app\models\ReportProduct[] */

$this->title = "Изменить отчет $report->date";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $factory->name, 'url' => ['view', 'id' => $factory->id]];
$this->params['breadcrumbs'][] = ['label' => 'Отчет #' . $report->id, 'url' => ['view-report', 'id' => $report->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-update">
    <div class="card">
        <div class="card-body">
            <div class="report-form">
                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-2">
                        <?= $form->field($report, 'date')->input('date') ?>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Продукт</th>
                        <th>Количество</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= Html::encode($product->name) ?></td>
                            <td>
                                <?php
                                $amount = isset($reportProducts[$product->id]) ? $reportProducts[$product->id]->amount : 0;
                                ?>
                                <?= Html::activeInput('number', $report, "reportProductsData[$product->id][amount]", [
                                    'value' => $amount,
                                    'class' => 'form-control',
                                    'min' => '0',
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-pen"></i> Изменить отчет', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
