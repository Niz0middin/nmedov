<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var \yii\web\View $this */
/** @var \app\models\LoginForm $model */

$this->title = 'Войти';
?>

<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Войдите</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['autocomplete' => 'off']]); ?>

        <?= $form->field($model, 'username', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><i class="fas fa-envelope"></i></div></div>',
            'template' => "{beginWrapper}{input}{error}{endWrapper}",
            'wrapperOptions' => [
                'class' => 'input-group mb-3'
            ]
        ])
            ->label(false)
            ->textInput(['placeholder' => 'Логин']); ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><i class="fas fa-lock"></i></div></div>',
            'template' => "{beginWrapper}{input}{error}{endWrapper}",
            'wrapperOptions' => [
                'class' => 'input-group mb-3'
            ]
        ])
            ->label(false)
            ->passwordInput(['placeholder' => 'Пароль']); ?>

        <div class="row">
<!--            <div class="col-8">-->
<!--                <div class="icheck-primary">-->
<!--                    --><?php //= $form->field($model, 'rememberMe')->checkbox(); ?>
<!--                </div>-->
<!--            </div>-->

            <div class="col-12">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-danger btn-block', 'name' => 'login-button']); ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
