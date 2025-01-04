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
        return [
            'id' => $model->id,
            'onclick' => 'window.location.href = "' . Url::to(['/factory/view-storage', 'id' => $model->id]) . '"',
            'style' => 'cursor: pointer;'
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
            'attribute' => 'amount',
            'value' => function ($storage) {
                return MainHelper::priceFormat($storage->amount);
            },
            'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'amount')))
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
        ],
        [
            'attribute' => 'remaining_amount',
            'value' => function ($storage) {
                return MainHelper::priceFormat($storage->remaining_amount);
            },
            'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'remaining_amount')))
        ],
        [
            'attribute' => 'remaining_sht',
            'value' => function ($storage) {
                return MainHelper::priceFormat($storage->remaining_sht);
            },
            'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'remaining_sht')))
        ],
        [
            'attribute' => 'remaining_kg',
            'value' => function ($storage) {
                return MainHelper::priceFormat($storage->remaining_kg);
            },
            'footer' => MainHelper::priceFormat(array_sum(array_column($models, 'remaining_kg')))
        ]
    ],
]);

?>
<style>
    tfoot {
        font-weight: bold;
    }
</style>
