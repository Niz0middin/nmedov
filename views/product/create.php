<?php

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = 'Создать Продукт';
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
