<?php

use app\helpers\MainHelper;
use yii\bootstrap4\LinkPager;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\search\FactorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заводы';
$this->params['breadcrumbs'][] = $this->title;

$states = MainHelper::STATES;
?>
<div class="factory-index">
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
                        'ondblclick' => 'window.open("'
                            . Yii::$app->urlManager->createUrl('/factory/view?id=') . '"+(this.id))',
                        'onmouseover' => '$("table tr").css("cursor", "pointer");',
                        'class' => $class
                    ];
                },
                'layout' => "{summary}\n{items}\n{pager}",
                'tableOptions' => [
                    'class' => 'footable table table-striped table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id',
                    'name',
                    [
                        'attribute' => 'status',
                        'filter' => $states,
                        'value' => function ($model) use ($states) {
                            return $states[$model->status] ?? $model->status;
                        },
                        'filterInputOptions' => ['class' => 'form-control input-sm', 'prompt' => 'Выберите'],
                    ],
                    'created_at',
//            'updated_at'
                ],
                'pager' => [
                    'class' => LinkPager::class
                ]
            ]); ?>
        </div>
    </div>
</div>
