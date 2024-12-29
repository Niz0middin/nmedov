<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Plan $plan */

$this->title = 'Изменить';
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $plan->factory->name, 'url' => ['view', 'id' => $plan->factory->id]];
$this->params['breadcrumbs'][] = ['label' => "План за $plan->month", 'url' => ['view-plan', 'id' => $plan->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="plan-update">
    <?= $this->render('_form-plan', [
        'plan' => $plan,
    ]) ?>
</div>
