<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$states = MainHelper::STATES
?>
<div class="product-view">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <?= Html::a('<i class="fa fa-pen"></i> Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <!--                        --><?php //= Html::a('<i class="fa fa-trash"></i> Удалить', ['delete', 'id' => $model->id], [
                    //                            'class' => 'btn btn-danger',
                    //                            'data' => [
                    //                                'confirm' => 'Are you sure you want to delete this item?',
                    //                                'method' => 'post',
                    //                            ],
                    //                        ]) ?>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'category_id',
                                'value' => function ($model) {
                                    return @$model->category->name;
                                }
                            ],
                            'name',
                            [
                                'attribute' => 'price',
                                'value' => function ($model) {
                                    return MainHelper::priceFormat($model->price);
                                },
                            ],
                            [
                                'attribute' => 'cost_price',
                                'value' => function ($model) {
                                    return MainHelper::priceFormat($model->cost_price);
                                },
                            ],
                            'unit',
                            [
                                'attribute' => 'status',
                                'value' => function ($model) use ($states) {
                                    return $states[$model->status] ?? $model->status;
                                }
                            ],
                            'created_at',
                            'updated_at',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
