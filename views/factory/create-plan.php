<?php

/** @var yii\web\View $this */
/** @var app\models\Plan $plan */
/** @var app\models\Factory $factory */

$this->title = 'Создать план';
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $factory->name, 'url' => ['view', 'id' => $factory->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-create">
    <?= $this->render('_form-plan', [
        'plan' => $plan,
    ]) ?>
</div>
