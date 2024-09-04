<?php

/** @var \yii\web\View $this */
/** @var string $directoryAsset */
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?= \yii\helpers\Html::a('<img class="brand-image elevation-3" src="/logo2.png" alt="APP"><span class="brand-text font-weight-light">'. @Yii::$app->user->identity->username .'</span>', Yii::$app->homeUrl, ['class' => 'brand-link']) ?>
    <div class="sidebar">

        <nav class="mt-2">
            <?= dmstr\adminlte\widgets\Menu::widget(
                [
                    'options' => ['class' => 'nav nav-pills nav-sidebar flex-column', 'data-widget' => 'treeview'],
                    'items' => \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id)
                ]
            ) ?>
        </nav>

    </div>

</aside>
