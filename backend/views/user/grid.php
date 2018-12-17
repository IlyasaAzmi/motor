<?php

use yii\grid\Gridview;
use yii\helpers\Html;

?>

<h2>User</h2>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'username',
        'email',
        [
            'header' => 'Transaksi',
            'content' => function ($model, $key, $index, $column) {
                $title = sprintf('Transaksis (%d)', $model->transaksisCount);
                return Html::a($title, ['transaksi/grids', 'Transaksi[customer_id]' => $model->id]);
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
