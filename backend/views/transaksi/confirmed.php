<?php

use yii\grid\Gridview;
use yii\helpers\Html;

$this->title = 'Transaksi Sukses';
$this->params['breadcrumbs'][] = ['label' => 'Transaksi', 'url' => ['/transaksi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'tableOptions' => ['class' => 'table table-bordered table-striped table-hover'],
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
        ],
        'transaksi_id',
        // [
        //     'header' => 'Motor',
        //     'filter' => Html::activeDropDownList($searchModel, 'motor_id', $motorFilterData, ['prompt' => '---all']),
        //     'content' => function($model) {
        //         return $model->motor->title;
        //     }
        // ],
        'motor_id',
        [
            'attribute' => 'motor_id',
            'label' => 'Merk Motor',
            'value' => 'motor.motor_name'
        ],
        'duration',
        [
            'attribute' => 'paket_id',
            'label' => 'Paket',
            'value' => 'paket.title'
        ],
        // 'customer_id',
        // 'user.username',
        [
            'attribute' => 'customer_id',
            'label' => 'Customer',
            'value' => 'user.username'
        ],
        'payment:currency',
        [
            'attribute' => 'status',
            'label' => 'Status',
            'format' => 'html',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model) {
                if ($model->status == 1) {
                    return '<span class="label label-success">Berhasil</span>';
                } else {
                    return '<span class="label label-warning">Proses</span>';
                }
            }
        ],

        [
            'class' => 'yii\grid\ActionColumn',
        ],
    ]
])
?>
