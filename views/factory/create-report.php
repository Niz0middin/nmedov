<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
                                <?= Html::activeInput('number', $report, "reportProductsData[$product->id][amount]", [
                                    'value' => isset($report->reportProductsData[$product->id]['amount']) ? $report->reportProductsData[$product->id]['amount'] : 0,
                                    'class' => 'form-control',
                                    'min' => '0',
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-plus"></i> Создать отчет', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
