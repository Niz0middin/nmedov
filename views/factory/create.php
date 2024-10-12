<?php

/** @var yii\web\View $this */
/** @var app\models\Factory $model */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="factory-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
