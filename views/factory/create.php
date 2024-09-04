<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Factory $model */

$this->title = 'Create Factory';
$this->params['breadcrumbs'][] = ['label' => 'Factories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="factory-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
