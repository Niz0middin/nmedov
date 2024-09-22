<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Factory $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="factory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(MainHelper::STATES) ?>

    <!--    --><?php //= $form->field($model, 'created_at')->textInput() ?>
    <!---->
    <!--    --><?php //= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
