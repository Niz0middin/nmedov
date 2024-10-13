<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Factory $model */
/** @var yii\bootstrap4\ActiveForm $form */
?>
<div class="factory-form">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'status')->dropDownList(MainHelper::STATES) ?>

                    <!--    --><?php //= $form->field($model, 'created_at')->textInput() ?>
                    <!---->
                    <!--    --><?php //= $form->field($model, 'updated_at')->textInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
