<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\ReportViewSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="report-view-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'factory_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'cash_amount') ?>

    <?= $form->field($model, 'transfer_amount') ?>

    <?php // echo $form->field($model, 'expense') ?>

    <?php // echo $form->field($model, 'expense_description') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'income') ?>

    <?php // echo $form->field($model, 'cost_price') ?>

    <?php // echo $form->field($model, 'profit') ?>

    <?php // echo $form->field($model, 'sht') ?>

    <?php // echo $form->field($model, 'kg') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
