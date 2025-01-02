<?php

use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\StorageView $model */

$this->title = $model->date;
$this->params['breadcrumbs'][] = ['label' => 'Отчеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="storage-view-view">
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <div class="row">
                <div class="col-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'factory_id',
                            'date',
                            'cash_amount',
                            'transfer_amount',
                            'status',
                            'created_at',
                            'updated_at',
                            'income',
                            'cost_price',
                            'profit',
                            'sht',
                            'kg'
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
