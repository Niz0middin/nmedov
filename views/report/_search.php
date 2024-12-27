<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\ReportViewSearch $model */
/** @var yii\widgets\ActiveForm $form */

$range_placeholder = date('Y-m-01') . ' - ' . date('Y-m-d')
?>

<div class="report-view-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-7 col-md-10 col-sm-12">
            <div class="input-group">
                <?= $form->field($model, 'date_range')->widget(DateRangePicker::class, [
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-m-d',
                            'separator' => ' - ',
                        ],
                        'opens' => 'right',
                        'autoUpdateInput' => false,
                    ],
                    'options' => ['placeholder' => $range_placeholder],
                ])->label(false); ?>
                <span class="input-group-btn">
                <?= Html::submitButton('<i class="fa fa-filter"></i>  Фильтровать по периоду', ['class' => 'btn btn-primary', 'style' => 'margin-left:10px']) ?>
                <?= Html::a('<i class="fa fa-refresh"></i> Сбросить фильтр', Yii::$app->urlManager->createUrl('/report/index'), ['class' => 'btn btn-warning', 'style' => 'display:inline-block;margin-left:10px;margin-right:10px']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
