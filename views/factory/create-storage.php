<?php

/* @var $this yii\web\View */
/* @var $factory app\models\Factory */
/* @var $storage app\models\Storage */
/* @var $products app\models\Product[] */

$this->title = "Добавить остаток по складу";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $factory->name, 'url' => ['view', 'id' => $factory->id]];
//$this->params['breadcrumbs'][] = ['label' => "План за {$storage->plan->month}", 'url' => ['view-plan', 'id' => $storage->plan->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-create">
    <?= $this->render('_form-storage', [
        'factory' => $factory,
        'storage' => $storage,
        'products' => $products
    ]) ?>
</div>
