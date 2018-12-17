<?php

use yii\grid\Gridview;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Transaksi;
use yii\widgets\ActiveForm;

$this->title = 'Pemasukan';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $total = 0;

foreach($dataProvider->models as $m)
{
   $total += $m->payment;
}?>

<h3>Biaya Sewa</h3>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'showFooter' => true,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
        ],
        // 'transaksi_id',
        [
            'attribute' => 'transaksi_id',
            'format' => 'html',
            'value' => function($model) {
                    return $model->transaksi_id;
            },
            'footer' => '<b>TOTAL</b>'
        ],
        'motor_id',
        // 'motor.motor_name',
        'paket_id',
        // 'paket.title',
        'customer_id',
        // [
        //     'header' => 'Customer',
        //     'attribute' => 'user.username'
        // ],
        // 'payment:currency',

        // [
        //     'attribute' => 'payment',
        //     'value' => function($data) {
        //         return \Yii::$app->formatter->asCurrency($data->payment);
        //         },
        //     'footer' => Transaksi::getTotal($dataProvider->models, 'payment'),
        // ],

        [
             'attribute' => 'payment',
             'contentOptions' => ['style'=>'text-align:right'],
             'value' => function($data) {
                  return \Yii::$app->formatter->asCurrency($data->payment);
             },
             'footer' => '<b>'. \Yii::$app->formatter->asCurrency($total) .'</b>'
        ],

        [
            'attribute' => 'payment_status',
            'label' => 'Pembayaran',
            'format' => 'html',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model) {
                if ($model->payment_status == 1) {
                    return '<span class="label label-info">Lunas</span>';
                } else {
                    return '<span class="label label-danger">Belum</span>';
                }
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
<hr />
<?php $jumlah = 0;

foreach($dataProvider2->models as $n)
{
   $jumlah += $n->charge;
}?>

<h3>Denda</h3>
<?= GridView::widget([
    'dataProvider' => $dataProvider2,
    // 'filterModel' => $searchModel,
    'showFooter' => true,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      // 'denda_id',
      [
          'attribute' => 'denda_id',
          'format' => 'html',
          'value' => function($model) {
                  return $model->denda_id;
          },
          'footer' => '<b>TOTAL</b>'
      ],
      'transaksi_id',
      // 'tipe',
      [
          'attribute' => 'tipe',
          'label' => 'Tipe Denda',
          'format' => 'html',
          'headerOptions' => ['class' => 'text-center'],
          'contentOptions' => ['class' => 'text-center'],
          'value' => function($model) {
              if ($model->tipe == 10) {
                  return 'Keterlambatan';
              } elseif ($model->tipe == 20) {
                  return 'Kerusakan';
              } elseif ($model->tipe == 30) {
                  return 'Keterlambatan dan Kerusakan';
              }
          }
      ],
      // 'charge',
      [
           'attribute' => 'charge',
           'contentOptions' => ['style'=>'text-align:right'],
           'value' => function($data) {
                return \Yii::$app->formatter->asCurrency($data->charge);
           },
           'footer' => '<b>'. \Yii::$app->formatter->asCurrency($jumlah) .'</b>'
      ],
      'note:ntext',
      //'created_at',

      ['class' => 'yii\grid\ActionColumn'],
    ]
])
?>
