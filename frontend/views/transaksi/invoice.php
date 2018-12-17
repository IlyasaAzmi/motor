<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use common\models\Transaksi;

/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */

$this->title = 'Kode Reservasi : ' .$model->transaksi_id;
// $this->params['breadcrumbs'][] = ['label' => 'Transaksis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Yii::$app->session->getFlash('success') ?>

<div class="transaksi-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->transaksi_id], ['class' => 'btn btn-primary']) ?> -->
        <?php if($model->isPaid()):?>

        <?php else:?>
            <?= Html::a('Batalkan Reservasi', ['delete', 'id' => $model->transaksi_id, 'idmtr'=>$model->motor->motor_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Anda yakin ingin membatalkan reservasi?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif?>

        <!-- <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> PDF', ['gen-pdf', 'id' => $model->transaksi_id], [
            'class' => 'btn btn-info'
        ]) ?> -->

        <?= Html::a('Kembali ke Home', ['/site/index'], [
            'class' => 'btn btn-primary pull-right'
        ]) ?>
    </p>

    <br><br>

    <div class="col-md-8">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'transaksi_id',

            [
                'attribute' => 'Customer',
                'value' => Yii::$app->user->identity->username,
            ],
            [
                'attribute' => 'Customer Email',
                'value' => Yii::$app->user->identity->email,
            ],
            'motor_id',
            'motor.motor_name',
            // 'transaksi_start_date:datetime',
            // 'transaksi_return_date:datetime',
            [
                'attribute' => 'transaksi_start_date',
                'label' => 'Tanggal Ambil',
                'value' => Yii::$app->formatter->asDate($model->transaksi_start_date)
            ],
            [
                'attribute' => 'transaksi_start_date',
                'label' => 'Jam Ambil',
                'value' => Yii::$app->formatter->asTime($model->transaksi_start_date)
            ],
            [
                'attribute' => 'transaksi_return_date',
                'label' => 'Tanggal Kembali',
                'value' => Yii::$app->formatter->asDate($model->transaksi_return_date)
            ],
            [
                'attribute' => 'transaksi_return_date',
                'label' => 'Jam Kembali',
                'value' => Yii::$app->formatter->asTime($model->transaksi_return_date)
            ],
            'duration',
            'paket.title',
            'transaksi_created_at:datetime',
            // [
            //     'attribute' => 'transaksi_created_at',
            //     'label' => 'Waktu Transaksi'
            // ],
            // 'transaksi_updated_at:datetime',
            'payment:currency',
            [
                'attribute' => 'payment_status',
                'label' => 'Status Bayar',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->payment_status == 1) {
                        return '<span class="label label-success">Lunas</span>';
                    } else {
                        return '<span class="label label-danger">Belum Lunas</span>';
                    }
                }
            ],
            [
                'attribute' => 'pengambilan_status',
                'label' => 'Status Ambil',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->pengambilan_status == 1) {
                        return '<span class="label label-success">Sudah Diambil</span>';
                    } else {
                        return '<span class="label label-danger">Belum Diambil</span>';
                    }
                }
            ],
            [
                'attribute' => 'jaminan_status',
                'label' => 'Jaminan',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->jaminan_status == Transaksi::STATUS_KTP) {
                        return '<span class="label label-success">KTP</span>';
                    } elseif ($model->jaminan_status == Transaksi::STATUS_KTM) {
                        return '<span class="label label-success">KTM</span>';
                    } else {
                        return '<span class="label label-danger">Belum</span>';
                    }
                }
            ],
            [
                'attribute' => 'pengembalian_status',
                'label' => 'Status Kembali',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->pengembalian_status == 1) {
                        return '<span class="label label-success">Sudah Dikembalikan</span>';
                    } else {
                        return '<span class="label label-danger">Belum Dikembalikan</span>';
                    }
                }
            ],
            [
                'attribute' => 'status',
                'label' => 'Status Transaksi',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->status == 1) {
                        return '<span class="label label-success">Berhasil</span>';
                    } else {
                        return '<span class="label label-danger">Belum Selesai</span>';
                    }
                }
            ],
        ],
    ]) ?>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 wow fadeIn">
        <div class="card">
            <div class="view overlay hm-white-light">
                <div class="mask"></div>
            </div>
            <div class="card-body">
              <?php if($model->isPaid()):?>
                  <span class="label label-success">Lunas</span>
                  <?php else:?>
                      <span class="label label-danger">Belum Bayar</span>
                  <?php endif?>
                <h5 class="text-center">Biaya:</h5>
                <h4 class="text-center"><?= Yii::$app->formatter->asCurrency($model->payment)?></h4>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 wow fadeIn">
        <div class="card">
            <div class="view overlay hm-white-light">
                <img src="<?= Yii::getAlias('@motorImgUrl').'/'.'motor'.$motor->gambar?>" class="img-fluid" style="padding:1rem;">
                <div class="mask"></div>
            </div>
            <div class="card-body">
                <h4 class="text-center"><?= $motor->motor_name?></h4>
                <p class="card-text text-center">ID Motor: <?= $motor->motor_id?></p>
            </div>
        </div>
    </div>

</div>
