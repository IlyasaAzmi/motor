<?php

use yii\grid\Gridview;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Motor Grids';
$this->params['breadcrumbs'][] = ['label' => 'Motor', 'url' => ['/motor/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php
    // $motorFilterData = yii\helpers\ArrayHelper::map( common\models\Motor::find()->all(), 'motor_id', function($model, $defaultValue) {
    //     return sprintf($model->title);
    // });
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'motor_id',
        'plat',
        'motor_name',
        'kategori.title',
        [
            'class' => 'yii\grid\DataColumn',
            'attribute'=>'kategori_id',
            'value'=>'kategori.title',
        ],
        'contributor_id',
        [
            'header' => 'Transaksi',
            'content' => function ($model, $key, $index, $column) {
                $title = sprintf('Transaksi (%d)', $model->transaksisCount);
                return Html::a($title, ['transaksi/grids', 'Transaksi[motor_id]' => $model->motor_id]);
            }
        ],

        [
            'attribute' => 'status',
            'label' => 'Status',
            'format' => 'html',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model) {
                if ($model->status == 1) {
                    return '<span class="label label-primary">Aktif</span>';
                } else {
                    return '<span class="label label-danger">Non-Aktif</span>';
                }
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
        ],
    ]
])
?>
