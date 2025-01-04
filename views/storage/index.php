<?php

/** @var yii\web\View $this */
/** @var app\models\search\StorageViewSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Остатки на складе';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storage-view-index">
    <div class="card">
        <div class="card-body" style="overflow-x:auto">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
            <?= $this->render('_grid-view', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'hasFactory' => true
            ]); ?>
        </div>
    </div>
</div>
