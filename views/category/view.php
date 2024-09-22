<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$states = MainHelper::STATES
?>
<div class="category-view">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>
                        <?= Html::a('<i class="fa fa-pen"></i> Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<!--                        --><?php //= Html::a('<i class="fa fa-trash"></i> Удалить', ['delete', 'id' => $model->id], [
//                            'class' => 'btn btn-danger',
//                            'data' => [
//                                'confirm' => 'Are you sure you want to delete this item?',
//                                'method' => 'post',
//                            ],
//                        ]) ?>
                    </p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'parent_id',
                                'value' => function ($model) {
                                    return $model->parent->name;
                                }
                            ],
                            'name',
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

