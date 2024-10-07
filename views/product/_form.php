<?php

use app\helpers\MainHelper;
use app\models\Category;
use app\models\Factory;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'factoryIds')->checkboxList(
                        ArrayHelper::map(Factory::activeItems(), 'id', 'name')
                    ) ?>

                    <?= $form->field($model, 'category_id')->dropDownList(Category::allCategories(), ['prompt' => 'Выберите']) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => 0.01]) ?>

                    <?= $form->field($model, 'unit')->dropDownList(MainHelper::UNITS) ?>

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
