<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Factory $model */

$this->title = 'Изменить Завод: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="factory-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
