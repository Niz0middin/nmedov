<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Storage $storage */
/** @var $storageProducts app\models\StorageProduct[] */

$this->title = "Остатка склада за $storage->date";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $storage->factory->name, 'url' => ['view', 'id' => $storage->factory->id]];
//if (isset($storage->plan->month)) {
//    $this->params['breadcrumbs'][] = ['label' => "План за {$storage->plan->month}", 'url' => ['view-plan', 'id' => $storage->plan->id]];
//}
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="storage-view">
    <div class="card">
        <div class="card-body">
            <?php if (/*$storage->status == 0 || */Yii::$app->user->can('admin')) : ?>
                <?= Html::a('<i class="fa fa-pen"></i> Изменить', ['update-storage', 'id' => $storage->id], ['class' => 'btn btn-primary']) ?>
            <?php endif ?>
            <?= Html::a('<i class="fa fa-file-excel"></i> Загрузить как Excel', ['excel-storage', 'id' => $storage->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'method' => 'post',
                ]
            ]) ?>
            <br>
            <?php if (!empty($storageProducts)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Продукт</th>
                        <th>Количество произведенного продукта за текущий день</th>
                        <th>Общий остаток продукта на складе</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($storageProducts as $storageProduct): ?>
                        <tr>
                            <td><?= $storageProduct->product->name ?></td>
                            <td><?= MainHelper::amountFormat($storageProduct->amount) . ' ' . $storageProduct->product->unit ?></td>
                            <td><?= MainHelper::amountFormat($storageProduct->remaining_amount) . ' ' . $storageProduct->product->unit ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Отчеты по этому заводу не найдены.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
