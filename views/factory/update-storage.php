<?php

/* @var $this yii\web\View */
/* @var $factory app\models\Factory */
/* @var $storage app\models\Storage */
/* @var $products app\models\Product[] */
/* @var $storageProducts app\models\StorageProduct[] */

$this->title = "Изменить";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $factory->name, 'url' => ['view', 'id' => $factory->id]];
//$this->params['breadcrumbs'][] = ['label' => "План за {$storage->plan->month}", 'url' => ['view-plan', 'id' => $storage->plan->id]];
$this->params['breadcrumbs'][] = ['label' => "Остатка склада за $storage->date", 'url' => ['view-storage', 'id' => $storage->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-update">
    <?= $this->render('_form-storage', [
        'factory' => $factory,
        'storage' => $storage,
        'products' => $products,
        'storageProducts' => $storageProducts
    ]) ?>
</div>
