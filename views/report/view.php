<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ReportView $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Report Views', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="report-view-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'factory_id',
            'date',
            'cash_amount',
            'transfer_amount',
            'expense',
            'expense_description',
            'status',
            'created_at',
            'updated_at',
            'income',
            'cost_price',
            'profit',
            'sht',
            'kg',
        ],
    ]) ?>

</div>
