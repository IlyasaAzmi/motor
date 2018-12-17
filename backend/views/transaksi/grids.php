<?php

use yii\grid\Gridview;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Transaksi';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php
$total = 0;
foreach($dataProvider->models as $m)
{
   $total += $m->payment;
?>

<?php
    // if(!empty($m->transaksi_id)):
        if ($m->motor->entrust_type == 70):
           $laba = (30/100) * $total;
           $bagi = $total - $laba;
           elseif ($m->motor->entrust_type == 50) :
               $laba = (50/100) * $total;
               $bagi = $total - $laba;
               elseif ($m->motor->entrust_type == 100) :
                   $laba = (100/100) * $total;
                   $bagi = $total - $laba;
              else:
                $laba = 0;
                $bagi = 0;
           endif;
    // endif;
}
?>

<?php
    // $motorFilterData = yii\helpers\ArrayHelper::map( common\models\Motor::find()->all(), 'motor_id', function($model, $defaultValue) {
    //     return sprintf($model->title);
    // });
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'showFooter' => true,
    'columns' => [
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
        'duration',
        // 'paket_id',
        'paket.title',
        // 'customer_id',
        [
            'attribute' => 'customer_id',
            'header' => 'Customer',
            'value' => 'user.username'
        ],
        // 'payment:currency',
        [
             'attribute' => 'payment',
             'value' => function($data) {
                  return Yii::$app->formatter->asCurrency($data->payment);
             },
             'footer' => '<b>'.Yii::$app->formatter->asCurrency($total).'</b>'
        ],

        [
            'attribute' => 'profit_sharing',
            'label' => 'Bagi Hasil',
            'format' => 'html',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'footerOptions' => ['class' => 'text-center'],
            'value' => function($model) {
                if ($model->motor->entrust_type == 70) {
                    $profit = (70/100) * $model->payment;
                    return Yii::$app->formatter->asCurrency($profit);
                } elseif ($model->motor->entrust_type == 50) {
                    $profit = (50/100) * $model->payment;
                    return  Yii::$app->formatter->asCurrency($profit);
                } elseif ($model->motor->entrust_type == 100) {
                    $profit = (0/100) * $model->payment;
                    return  Yii::$app->formatter->asCurrency($profit);
                } else {
                    return '<span class="label label-warning">Belum</span>';
                }
            },
            'footer' => '<b>'.Yii::$app->formatter->asCurrency($bagi).'</b>'
        ],

        [
            'attribute' => 'profit',
            'label' => 'Profit',
            'format' => 'html',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'footerOptions' => ['class' => 'text-center'],
            'value' => function($model) {
                if ($model->motor->entrust_type == 70) {
                    // return '<span class="label label-success">70</span>';
                    $laba = (30/100) * $model->payment;
                    return Yii::$app->formatter->asCurrency($laba);
                } elseif ($model->motor->entrust_type == 50) {
                    // return '<span class="label label-success">50</span>';
                    $laba = (50/100) * $model->payment;
                    return  Yii::$app->formatter->asCurrency($laba);
                } elseif ($model->motor->entrust_type == 100) {
                    // return '<span class="label label-success">50</span>';
                    $laba = (100/100) * $model->payment;
                    return  Yii::$app->formatter->asCurrency($laba);
                } else {
                    return '<span class="label label-warning">Belum</span>';
                }
            },
            'footer' => '<b>'.Yii::$app->formatter->asCurrency($laba).'</b>'
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
