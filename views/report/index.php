<?php

use app\models\ReportView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\ReportViewSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Report Views';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-view-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'factory_id',
            'date',
            'cash_amount',
            'transfer_amount',
            'expense',
            'expense_description',
            'status',
            'income',
            'cost_price',
            'profit',
            'sht',
            'kg',
            'created_at',
            //'updated_at',
        ],
    ]); ?>


</div>
