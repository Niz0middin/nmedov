<?php

use app\helpers\MainHelper;
use app\models\Category;
use app\models\Factory;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\search\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;

$states = MainHelper::STATES;
$categories = Category::allCategories();
?>
<div class="product-index">
    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return [
                        'id' => $model->id,
                        'ondblclick' => 'window.open("'
                            . Yii::$app->urlManager->createUrl('/product/view?id=') . '"+(this.id))',
                        'onmouseover' => '$("table tr").css("cursor", "pointer");'
                    ];
                },
                'tableOptions' => [
                    'class' => 'footable table table-striped table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
                    [
                        'attribute' => 'factory_id',
                        'value' => function ($model) {
                            return $model->factories ? implode(', ', ArrayHelper::getColumn($model->factories, 'name')) : 'No factory';
                        },
                        'filter' => ArrayHelper::map(Factory::find()->all(), 'id', 'name'),
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите']
                    ],
                    'name',
                    [
                        'attribute' => 'price',
                        'value' => function ($model) {
                            return MainHelper::priceFormat($model->price);
                        },
                    ],
                    [
                        'attribute' => 'unit',
                        'filter' => MainHelper::UNITS,
                        'value' => function ($model) {
                            return $model->unit;
                        },
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите'],
                    ],
                    [
                        'attribute' => 'category_id',
                        'filter' => $categories,
                        'value' => function ($model) {
                            return @$model->category->name;
                        },
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите'],
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => $states,
                        'value' => function ($model) use ($states) {
                            return $states[$model->status] ?? $model->status;
                        },
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите'],
                    ],
                    'created_at',
                    //'updated_at',
                ],
            ]); ?>
        </div>
    </div>
</div>
