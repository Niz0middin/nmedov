<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReportView $model */

$this->title = 'Create Report View';
$this->params['breadcrumbs'][] = ['label' => 'Report Views', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-view-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
