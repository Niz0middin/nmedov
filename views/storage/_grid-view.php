<?php

use app\helpers\MainHelper;
use app\models\Factory;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var app\models\search\StorageViewSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var bool $hasFactory */

$models = $dataProvider->getModels();
$states = MainHelper::REPORT_STATES;
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showFooter' => true,
    'rowOptions' => function ($model) {
        $class = '';
        if ($model->status == 0) {
            $class = 'table-warning';
        }
        return [
            'id' => $model->id,
            'onclick' => 'window.location.href = "' . Url::to(['/factory/view-storage', 'id' => $model->id]) . '"',
            'style' => 'cursor: pointer;',
            'class' => $class
        ];
    },
    'tableOptions' => [
        'class' => 'footable table table-striped table-hover',
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'visible' => $hasFactory,
            'attribute' => 'factory_id',
            'value' => function ($model) {
                return $model->factory->name;
            },
            'filter' => ArrayHelper::map(Factory::find()->all(), 'id', 'name'),
            'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите']
        ],
        [
            'attribute' => 'date',
            'value' => 'date',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'date',
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'daysOfWeekDisabled' => [0]
                ],
                'options' => ['placeholder' => 'Введите дату ...'],
            ]),
            'footer' => 'Общий:'
        ],
        [
            'attribute' => 'income',
            'value' => function ($storage) {
                return MainHelper::priceFormat($storage->income);
            },
            'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'income')))
        ],
        [
            'attribute' => 'cost_price',
            'value' => function ($storage) {
                return MainHelper::priceFormat($storage->cost_price);
            },
            'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'cost_price')))
        ],
        [
            'attribute' => 'profit',
            'value' => function ($storage) {
                return MainHelper::priceFormat($storage->profit);
            },
            'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'profit')))
        ],
        [
            'attribute' => 'sht',
            'value' => function ($storage) {
                return MainHelper::priceFormat($storage->sht);
            },
            'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'sht')))
        ],
        [
            'attribute' => 'kg',
            'value' => function ($storage) {
                return MainHelper::priceFormat($storage->kg);
            },
            'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'kg')))
        ]
    ],
]);

?>
<style>
    tfoot {
        font-weight: bold;
    }
</style>
