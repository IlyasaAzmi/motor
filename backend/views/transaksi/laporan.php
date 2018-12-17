<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Url;
// use jino5577\daterangepicker\DateRangePicker; //daterange picker widget

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TransaksiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekap Bulanan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <h3>Denda</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
                  } else {
                      return 'Kerusakan';
                  }
              }
          ],
          // 'charge',
          [
               'attribute' => 'charge',
               'value' => function($data) {
                    return \Yii::$app->formatter->asCurrency($data->charge);
               },
               // 'footer' => '<b>'. \Yii::$app->formatter->asCurrency($jumlah) .'</b>'
          ],
          'note:ntext',
          //'created_at',

          ['class' => 'yii\grid\ActionColumn'],
        ]
    ])
    ?>
</div>
