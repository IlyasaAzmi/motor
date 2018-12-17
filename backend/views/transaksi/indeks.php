<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Url;
use backend\models\DateForm;
// use jino5577\daterangepicker\DateRangePicker; //daterange picker widget

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TransaksiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekap Transaksi Bulanan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $total = 0;

    foreach($dataProvider->models as $m)
    {
       $total += $m->payment;
    }?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!-- <?= Html::a('Create Transaksi', ['create'], ['class' => 'btn btn-success']) ?> -->
        <?= Html::a('Kembali Tentukan Bulan', ['date'], ['class' => 'btn btn-info']) ?>
    </p>

    <?php
    $gridColumns = [
        'transaksi_id',
        'motor_id',
        'customer_id',
        'paket_id',
        'transaksi_start_date',
        'transaksi_return_date',
        'duration',
        'transaksi_created_at',
    ];

    //Renders a export dropdown menu
    echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns
        ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'transaksi_id',
            [
                 'attribute' => 'transaksi_id',
                 'footer' => '<b>TOTAL</b>'
            ],
            'motor_id',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute'=>'motor_id',
                'label' => 'Motor',
                'value'=>'motor.motor_name',
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute'=>'customer_id',
                'value' => 'user.username'
            ],
            'duration',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute'=>'paket_id',
                'value' => 'paket.title'
            ],
            // 'transaksi_start_date',
            // 'transaksi_return_date',
            // 'payment:currency',
            [
                 'attribute' => 'payment',
                 'value' => function($data) {
                      return \Yii::$app->formatter->asCurrency($data->payment);
                 },
                 'footer' => '<b>'.\Yii::$app->formatter->asCurrency($total).'</b>'
            ],

            // DATE RANGE PICKER
            // [
          	// 		// the attribute
          	// 		'attribute' => 'transaksi_created_at',
          	// 		// format the value
          	// 		// 'value' => function ($model) {
          	// 		// 	if (extension_loaded('intl')) {
            // 		// 			// return Yii::t('app', '{0, date, MMMM dd, YYYY HH:mm}', [$model->transaksi_created_at]);
            //     //       return Yii::t('app', '{0, date, MMMM dd, YYYY HH:mm}', $_GET[$model->transaksi_created_at]);
          	// 		// 	} //else {
            // 		// 			// return date('Y-m-d G:i:s', $model->transaksi_created_at);
            // 		// 			return date('Y-m-d G:i:s', $_GET[$model->transaksi_created_at]);
          	// 		// 	// }
          	// 		// },
          	// 		// some styling?
          	// 		'headerOptions' => [
          	// 			'class' => 'col-md-2'
          	// 		],
          	// 		// here we render the widget
          	// 		'filter' => DateRangePicker::widget([
          	// 			'model' => $searchModel,
          	// 			'attribute' => 'transaksi_created_at_range',
          	// 			'pluginOptions' => [
          	// 			'format' => 'Y-m-d',
          	// 			'autoUpdateInput' => false
          	// 		]
          	// 		])
        		// ],

            //'transaksi_created_at',
            // 'transaksi_updated_at',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

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
          // 'transaksi_id',
          [
              'attribute' => 'transaksi_id',
              'label' => 'Transaksi',

              'content' => function ($model, $key, $index, $column) {
                  $title = sprintf($model->transaksi_id);
                  return Html::a($title, ['/transaksi/view', 'id' => $model->transaksi_id]);
              }
          ],
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
                  } else {
                      return 'Keterlambatan dan Kerusakan';
                  }
              }
          ],
          // 'charge',
          [
               'attribute' => 'charge',
               'value' => function($data) {
                    return \Yii::$app->formatter->asCurrency($data->charge);
               },
               'footer' => '<b>'. \Yii::$app->formatter->asCurrency($jumlah) .'</b>'
          ],
          'note:ntext',
          //'created_at',

          // ['class' => 'yii\grid\ActionColumn'],
          [
              'class' => 'yii\grid\ActionColumn',
              'urlCreator' => function ($action, $model, $key, $index) {
                  return Url::to(['denda/'.$action, 'id' => $model->denda_id]);
              }
          ],
        ]
    ])
    ?>
</div>
