<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $factory app\models\Factory */
/* @var $storage app\models\Storage */
/* @var $products app\models\Product[] */
/* @var $storageProducts app\models\StorageProduct[] */

?>
<div class="storage-form">
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($storage, 'date')->widget(DatePicker::class, [
                        'options' => [
                            'placeholder' => 'Введите дату отчета ...',
                        ],
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            'daysOfWeekDisabled' => [0]]
                    ]); ?>
                    <?= $form->field($storage, 'factory_id')->hiddenInput()->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Продукт</th>
                            <th>Количество произведенного продукта за текущий день</th>
                            <th>Общий остаток продукта на складе</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= Html::encode($product->name) ?></td>
                                <td>
                                    <div class="input-group">
                                        <?= Html::activeInput('number', $storage, "storageProductsData[$product->id][amount]", [
                                            'value' => $storageProducts[$product->id]['amount'] ?? 0,
                                            'class' => 'form-control',
                                            'step' => 1,
                                            'min' => 0,
                                        ]) ?>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><?= $product->unit ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <?= Html::activeInput('number', $storage, "storageProductsData[$product->id][remaining_amount]", [
                                            'value' => $storageProducts[$product->id]['remaining_amount'] ?? 0,
                                            'class' => 'form-control',
                                            'step' => 1,
                                            'min' => 0,
                                        ]) ?>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><?= $product->unit ?></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
