<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Factory $model */

$this->title = 'Update Factory: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Factories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="factory-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
