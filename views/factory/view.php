<?php

use app\helpers\MainHelper;
use kartik\widgets\DatePicker;
use yii\bootstrap4\LinkPager;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Factory $factory */
/* @var $reports app\models\Report[] */
/** @var app\models\search\ReportSearch $reportSearchModel */
/** @var yii\data\ActiveDataProvider $reportDataProvider */

$this->title = $factory->name;
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$states = MainHelper::REPORT_STATES

?>
<div class="factory-view">
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <p>
                <!--                        --><?php //= Html::a('<i class="fa fa-pen"></i> Изменить', ['update', 'id' => $factory->id], ['class' => 'btn btn-primary']) ?>
                <!--                        --><?php //= Html::a('<i class="fa fa-trash"></i> Удалить', ['delete', 'id' => $report->id], [
                //                            'class' => 'btn btn-danger',
                //                            'data' => [
                //                                'confirm' => 'Are you sure you want to delete this item?',
                //                                'method' => 'post',
                //                            ],
                //                        ]) ?>
                <?= Html::a('<i class="fa fa-plus"></i> Создать отчет', ['create-report', 'id' => $factory->id], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $reportDataProvider,
                'filterModel' => $reportSearchModel,
                'rowOptions' => function ($report, $key, $index, $grid) {
                    $class = '';
                    if ($report->status == 0) {
                        $class = 'table-warning';
                    }
                    return [
                        'id' => $report->id,
                        'onclick' => 'window.location.href = "' . Url::to(['view-report', 'id' => $report->id]) . '"',
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
                        'attribute' => 'overall',
                        'label' => 'Сумма',
                        'value' => function ($model) {
                            $sht = $kg = 0;
                            foreach ($model->reportProducts as $reportProduct) {
                                $product = $reportProduct->product;
                                if ($product->unit == 'шт') {
                                    $sht += $reportProduct->amount;
                                } else {
                                    $kg += $reportProduct->amount;
                                }
                            }
                            return "$sht шт, $kg кг";
                        }
                    ],
                    [
                        'attribute' => 'date',
                        'value' => 'date',
                        'filter' => DatePicker::widget([
                            'model' => $reportSearchModel,
                            'attribute' => 'date',
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'daysOfWeekDisabled' => [0]
                            ],
                            'options' => ['placeholder' => 'Введите дату ...'],
                        ])
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
                            'model' => $reportSearchModel,
                            'attribute' => 'created_at',
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                                'daysOfWeekDisabled' => [0]
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
