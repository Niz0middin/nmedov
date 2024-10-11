<?php

use app\helpers\MainHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Factory $factory */
/* @var $reports app\models\Report[] */

$this->title = "Ежедневные отчеты для $factory->name";
$this->params['breadcrumbs'][] = ['label' => 'Заводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$states = MainHelper::STATES

?>
<div class="factory-view">
    <div class="card">
        <div class="card-body">
            <p>
                <!--                        --><?php //= Html::a('<i class="fa fa-pen"></i> Изменить', ['update', 'id' => $factory->id], ['class' => 'btn btn-primary']) ?>
                <!--                        --><?php //= Html::a('<i class="fa fa-trash"></i> Удалить', ['delete', 'id' => $model->id], [
                //                            'class' => 'btn btn-danger',
                //                            'data' => [
                //                                'confirm' => 'Are you sure you want to delete this item?',
                //                                'method' => 'post',
                //                            ],
                //                        ]) ?>
                <?= Html::a('<i class="fa fa-plus"></i> Создать отчет', ['create-report', 'id' => $factory->id], ['class' => 'btn btn-success']) ?>
            </p>
            <?php if (!empty($reports)): ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <td>Overall</td>
<!--                        <th>Products</th>-->
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reports as $report): ?>
                        <?php $sht = $kg = 0 ?>
                        <tr>
                            <td><?= Html::encode($report->date) ?></td>
<!--                            <td>-->
<!--                                <ul>-->
<!--                                    --><?php //foreach ($report->reportProducts as $rp): ?>
<!--                                        <li>--><?php //= Html::encode($rp->product->name) ?>
<!--                                            : --><?php //= Html::encode($rp->amount) ?><!--</li>-->
<!--                                    --><?php //endforeach; ?>
<!--                                </ul>-->
<!--                            </td>-->
                            <?php foreach ($report->reportProducts as $rp): ?>
                                <?php
                                if ($rp->product->unit == 'sht') {
                                    $sht += $rp->amount;
                                } else {
                                    $kg += $rp->amount;
                                }
                                ?>
                            <?php endforeach; ?>
                            <td><?= Html::encode("$sht sht, $kg kg") ?></td>
                            <td>
                                <?= Html::a('Update', ['update-report', 'id' => $report->id], ['class' => 'btn btn-primary btn-sm']) ?>
                                <?= Html::a('View', ['view-report', 'id' => $report->id], ['class' => 'btn btn-success btn-sm']) ?>
                                <?= Html::a('Delete', ['delete-report', 'id' => $report->id], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this report?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Отчеты по этому заводу не найдены.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
