<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReportView $model */

$this->title = 'Update Report View: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Report Views', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-view-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
