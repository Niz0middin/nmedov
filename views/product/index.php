<?php

use app\helpers\MainHelper;
use app\models\Category;
use app\models\Factory;
use kartik\widgets\DatePicker;
use yii\bootstrap4\LinkPager;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

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
        <div class="card-body" style="overflow-x:auto">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function ($model, $key, $index, $grid) {
                    $class = '';
                    if ($model->status == 0) {
                        $class = 'table-danger';
                    }
                    return [
                        'id' => $model->id,
                        'onclick' => 'window.location.href = "' . Url::to(['view', 'id' => $model->id]) . '"',
                        'style' => 'cursor: pointer;',
                        'class' => $class
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
                        'attribute' => 'cost_price',
                        'value' => function ($model) {
                            return MainHelper::priceFormat($model->cost_price);
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
                    [
                        'attribute' => 'created_at',
                        'value' => 'created_at',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'created_at',
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true
                            ],
                            'options' => ['placeholder' => 'Введите дату ...'],
                        ])
                    ],
                    //'updated_at',
                ],
                'pager' => [
                    'class' => LinkPager::class
                ]
            ]); ?>
        </div>
    </div>
</div>
