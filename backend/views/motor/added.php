<?php

use yii\grid\Gridview;
use yii\helpers\Html;

$this->title = 'Motor Pending';
$this->params['breadcrumbs'][] = ['label' => 'Motor', 'url' => ['/motor/index']];
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
        'motor_id',
        'plat',
        'motor_name',
        // 'kategori_id',
        [
            'class' => 'yii\grid\DataColumn',
            'attribute'=>'kategori_id',
            'value'=>'kategori.title',
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'attribute'=>'contributor_id',
            'value'=>'contributor.name',
        ],
        // 'contributor_id',
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
            'attribute' => 'current_status',
            'label' => 'Kondisi',
            'format' => 'html',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model) {
                if ($model->current_status == 10) {
                    return '<span class="label label-success">Available</span>';
                } elseif ($model->current_status == 20) {
                    return '<span class="label label-warning">Booked</span>';
                } elseif ($model->current_status == 30) {
                    return '<span class="label label-primary">On Rent</span>';
                } else {
                    return '<span class="label label-default">Pending</span>';
                }
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
        ],
    ]
])
?>
