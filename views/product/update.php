<?php

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = 'Изменить Продукт: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="product-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
