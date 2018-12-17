<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\helpers\Url;
use common\models\Transaksi;

/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */

$this->title = 'Kode Reservasi : ' .$model->transaksi_id;
// $this->params['breadcrumbs'][] = ['label' => 'Transaksis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->transaksi_id], ['class' => 'btn btn-primary']) ?> -->
        <?php if($model->isPaid()):?>
            <?= Html::a('Bukti Pembayaran', ['/kwitansi/view', 'id' => $model->kwitansi->kwitansi_id], [
                'class' => 'btn btn-primary'
            ]) ?>
        <?php else:?>
            <?= Html::a('Batalkan Reservasi', ['delete', 'id' => $model->transaksi_id, 'idmtr'=>$model->motor->motor_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Anda yakin ingin membatalkan reservasi?',
                    'method' => 'post',
                ],
            ]) ?>
            <?php if($model->invoice):?>
            <?= Html::a('Invoice', ['/invoice/view', 'id' => $model->invoice->invoice_id], [
                'class' => 'btn btn-info'
            ]) ?>
            <?php endif?>
        <?php endif?>

        <!-- <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> PDF', ['gen-pdf', 'id' => $model->transaksi_id], [
            'class' => 'btn btn-info'
        ]) ?> -->

        <?php if ($model->status == 1) :?>
            <?php if (empty($model->feedback->feedback_id)) :?>
                <a href="<?=Url::to(['/feedback/create','id'=>$model->transaksi_id])?>" class="btn btn-default">Feedback</a>
            <?php endif?>
        <?php endif?>
    </p>

<div class="row">
    <div class="col-md-4">
    <h3>Customer</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'Customer',
                'value' => Yii::$app->user->identity->username,
            ],
            [
                'attribute' => 'Nama Lengkap',
                'value' => Yii::$app->user->identity->profile->name,
            ],
            [
                'attribute' => 'Prodi',
                'value' => Yii::$app->user->identity->prodi,
            ],
            [
                'attribute' => 'Asrama',
                'value' => Yii::$app->user->identity->asrama,
            ],
            [
                'attribute' => 'Phone',
                'value' => Yii::$app->user->identity->phone,
            ],
            [
                'attribute' => 'Customer Email',
                'value' => Yii::$app->user->identity->email,
            ],
        ],
    ]) ?>

    <h3>Status</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'payment_status',
                'label' => 'Pembayaran',
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

    <div class="col-md-4">
    <h3>Detail Reservasi</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'transaksi_id',
            'motor_id',
            'motor.motor_name',
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
            'transaksi_created_at',
            // 'transaksi_updated_at',
            'payment:currency',
        ],
    ]) ?>
    </div>

    <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 wow fadeIn">
        <h3>Biaya</h3>
        <div class="card">
            <div class="view overlay hm-white-light">
                <div class="mask"></div>
            </div>
            <div class="card-body">
              <?php if($model->isPaid()):?>
                  <div class="text-center">
                      <span class="label label-success">Lunas</span>
                  </div>
                  <?php else:?>
                      <div class="text-center">
                          <span class="label label-danger">Belum Bayar</span>
                      </div>
                  <?php endif?>
                <h4 class="text-center"><?= Yii::$app->formatter->asCurrency($model->payment)?></h4>
            </div>
        </div>
    </div> -->

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 wow fadeIn">
        <h3>Motor</h3>
        <div class="card">
            <div class="view overlay hm-white-light">
                <img src="<?= Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->motor->gambar?>" class="img-fluid" style="padding:1rem;">
                <div class="mask"></div>
            </div>
            <div class="card-body">
                <h4 class="text-center"><?= $model->motor->motor_name?></h4>
                <p class="card-text text-center">ID Motor: <?= $model->motor->motor_id?></p>
            </div>
        </div>
    </div>
</div>

  <div class="col-md-6">
      <div class="panel panel-default">
          <div class="panel-heading"><strong><?php echo Yii::t('app', 'Feedback');?></strong>
              <?php if (!empty($model->feedback->feedback_id)) :?>
                  <?= Html::a('Detail', ['/feedback/view', 'id' => $model->feedback->feedback_id], ['class' => 'pull-right label label-default']) ?>
              <?php endif?>
          </div>
          <div class="panel-body">
            <?php if (!empty($model->feedback->feedback_id)) :?>
                <?=$model->feedback->note?>
            <?php else :?>
                <span class="label label-danger">Tidak Ada</span>
            <?php endif?>
          </div>
      </div>

      <div class="panel panel-default">
          <div class="panel-heading"><strong><?php echo Yii::t('app', 'Denda');?></strong></div>
          <div class="panel-body">
            <?php if (!empty($model->denda->denda_id)) :?>
                <?=$model->denda->note?>
                <span class="pull-right"><?= Yii::$app->formatter->asCurrency($model->denda->charge)?></span>
            <?php else :?>
                <span class="label label-danger">Tidak Ada</span>
            <?php endif?>
          </div>
      </div>
  </div>

  <?php if (!empty($model->denda->denda_id)) :
  $m = $model->payment;
  $n = $model->denda->charge;
  $total = $m + $n;
  else :
    $m = $model->payment;
    $n = 0;
    $total = $m + $n;
  endif?>
  <div class="col-md-6">
      <div class="panel panel-default">
          <div class="panel-heading"><strong><?php echo Yii::t('app', 'Pembayaran');?></strong></div>
          <div class="panel-body">
            <p>
              Biaya sewa
              <?php if($model->isPaid()):?>
                  <span class="label label-success">Lunas</span>
              <?php else:?>
                  <span class="label label-danger">Belum Bayar</span>
              <?php endif?>

              <span class="pull-right"><?= Yii::$app->formatter->asCurrency($model->payment)?></span>
            </p>
            <p>
              <?php if (!empty($model->denda->denda_id)) :?>
                  Denda
                  <span class="pull-right"><?= Yii::$app->formatter->asCurrency($model->denda->charge)?></span>
                  <?php if($model->denda->isPayed()):?>
                      <span class="label label-success">Lunas</span>
                  <?php else:?>
                      <span class="label label-danger">Belum Bayar</span>
                  <?php endif?>

              <?php else :?>
                  Denda
                  <span class="pull-right label label-danger">Tidak Ada</span>
              <?php endif?>
            </p>
            <hr />
            <p>
              <b>TOTAL</b>
              <b><span class="pull-right"><?= Yii::$app->formatter->asCurrency($total)?></span></b>
            </p>

          </div>
      </div>
  </div>



</div>
