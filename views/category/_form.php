<?php

use app\helpers\MainHelper;
use app\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'parent_id')->dropDownList(Category::parents()) ?>

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
