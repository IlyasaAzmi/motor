<?php

use yii\grid\Gridview;
use yii\helpers\Html;

$this->title = 'Transaksi Lunas';
$this->params['breadcrumbs'][] = ['label' => 'Transaksi', 'url' => ['/transaksi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
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
        'motor.motor_name',
        'paket_id',
        'paket.title',
        'customer_id',
        // 'user.username',
        [
            'header' => 'Customer',
            'attribute' => 'user.username'
        ],
        'payment:currency',

        // 'transaksi_created_at',
        // 'transaksi_updated_at',
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
