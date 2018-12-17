<?php

use yii\grid\Gridview;
use yii\helpers\Html;

?>

<h2>User</h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        'username',
        'email',
        [
            'header' => 'Reservations',
            'content' => function ($model, $key, $index, $column) {
                return Html::a('Transaksi',
                ['transaksi/grid', 'Transaksi[customer_id]' => $model->transaksi_id]);
            }
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'header' => 'Actions',
        ]
    ]
])
?>
