<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Multiple Grid';
?>

<h1><?= Html::encode($this->title) ?></h1>
<br />

<h2>Transaksi</h2>
<?= Gridview::widget([
    'dataProvider' => $transaksiDataProvider,
    'filterModel' => $transaksiSearchModel,
    'tableOptions' => ['class' => 'table  table-bordered table-hover'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'transaksi_id',
        'customer_id',
        'motor_id',
        'transaksi_start_date',
        'return_date',
        ['class' => 'yii\grid\ActionColumn'],
    ],
  ]) ?>

  <h2>Motor</h2>
  <?= Gridview::widget ([
        'dataProvider' => $motorDataProvider,
        'filterModel' => $motorSearchModel,
        'tableOptions' => ['class' => 'table  table-bordered table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'motor_id',
            'title',
            'plat',
            'start_date',
            'expired_date',
            ['class' => 'yii\grid\ActionColumn'],
        ]
    ]) ?>
