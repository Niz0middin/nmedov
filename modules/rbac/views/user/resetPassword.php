<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \mdm\admin\models\form\ResetPassword */

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    

    <p>Please choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'retypePassword')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('rbac-admin', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
