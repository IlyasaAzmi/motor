<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProfitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profit-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $laba = 0;
    $bagi = 0;
    $total = 0;
    $tambah = 0;

    foreach($dataProvider->models as $m)
    {
       $laba += $m->profit;
       $bagi += $m->sharing;
       $total += $m->transaksi->payment;
       // $tambah += $m->transaksi->denda->charge;
    }
    ?>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!-- <?= Html::a('Create Profit', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'profit_id',
            'transaksi_id',
            'motor_id',
            // [
            //      'attribute' => 'motor_id',
            //      'label' => 'Motor',
            //      'value' => function($data) {
            //           return $data->transaksi->motor->motor_name.' - '.$data->transaksi->motor_id;
            //      },
            // ],
            // 'contributor_id',
            [
                 'attribute' => 'contributor_id',
                 'label' => 'Contributor',
                 'filter'=> ArrayHelper::map(\common\models\Contributor::find()->all(), 'contributor_id', 'name'),
                 'value' => function($data) {
                      return $data->contributor->name.' - '.$data->contributor_id;
                 },
            ],
            [
                 'attribute' => 'transaksi.biaya',
                 'headerOptions' => ['class' => 'text-center'],
                 'contentOptions' => ['style'=>'text-align:right'],
                 'value' => function($data) {
                      return Yii::$app->formatter->asCurrency($data->transaksi->payment);
                 },
                 'footer' => '<b>'.Yii::$app->formatter->asCurrency($total).'</b>',
                 'footerOptions' => ['style'=>'text-align:right'],
            ],
            // [
            //      'attribute' => 'transaksi.denda',
            //      'headerOptions' => ['class' => 'text-center'],
            //      'contentOptions' => ['class' => 'text-center'],
            //      'footerOptions' => ['class' => 'text-center'],
            //      'value' => function($data) {
            //           if(!empty($data->transaksi->denda->denda_id)){
            //               return Yii::$app->formatter->asCurrency($data->transaksi->denda->charge);
            //           } else {
            //               return '0';
            //           }
            //
            //      },
            //      // 'footer' => '<b>'.Yii::$app->formatter->asCurrency($tambah).'</b>'
            // ],
            [
                 'attribute' => 'profit',
                 'headerOptions' => ['class' => 'text-center'],
                 'contentOptions' => ['style'=>'text-align:right'],
                 'value' => function($data) {
                      return Yii::$app->formatter->asCurrency($data->profit);
                 },
                 'footer' => '<b>'.Yii::$app->formatter->asCurrency($laba).'</b>',
                 'footerOptions' => ['style'=>'text-align:right'],
            ],

            [
                 'attribute' => 'sharing',
                 'label' => 'Bagi Hasil',
                 'headerOptions' => ['class' => 'text-center'],
                 'contentOptions' => ['style'=>'text-align:right'],
                 'value' => function($data) {
                      return Yii::$app->formatter->asCurrency($data->sharing);
                 },
                 'footer' => '<b>'.Yii::$app->formatter->asCurrency($bagi).'</b>',
                 'footerOptions' => ['style'=>'text-align:right'],
            ],
            [
                'attribute' => 'motor.entrust_type',
                'label' => 'Tipe Penitipan',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                // 'filter'=>array("Full"=>"Full","70:30"=>"70","50:50"=>"50"),
                'value' => function($model) {
                    if ($model->transaksi->motor->entrust_type == 70) {
                        return '<span class="label label-primary">70:30</span>';
                    } elseif ($model->transaksi->motor->entrust_type == 50) {
                        return '<span class="label label-info">50:50</span>';
                    } elseif ($model->transaksi->motor->entrust_type == 100) {
                        return '<span class="label label-default">Full</span>';
                    } else {
                        return '<span class="label label-danger">Belum Ditentukan</span>';
                    }
                }
            ],
            // 'created_at',
            [
                'attribute' => 'created_at',
                'label' => 'Tanggal',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                // 'value' => 'created_at',
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'short');
                },
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'options' => ['placeholder' => 'Enter date'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]),
            ]

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
