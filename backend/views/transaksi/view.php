<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\Transaksi;

/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */

$this->title = 'Kode Reservasi : ' .$model->transaksi_id;
$this->params['breadcrumbs'][] = ['label' => 'Transaksis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <!-- <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Update', ['update', 'id' => $model->transaksi_id], ['class' => 'btn btn-primary']) ?> -->
        <?php if(empty($model->denda->denda_id)):?>
            <?php if($model->isReturned() && $model->status == 0):?>
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Denda', ['/denda/create', 'id' => $model->transaksi_id], ['class' => 'btn btn-primary']) ?>
            <?php endif?>
        <?php endif?>

        <?php if($model->isConfirmed()):?>
          <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['delete', 'id' => $model->transaksi_id, 'idmtr'=>$model->motor->motor_id], [
              'class' => 'btn btn-danger disabled',
              'data' => [
                  'confirm' => 'Are you sure you want to delete this item?',
                  'method' => 'post',
              ],
          ]) ?>
            <?php else:?>
              <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['delete', 'id' => $model->transaksi_id, 'idmtr'=>$model->motor->motor_id], [
                  'class' => 'btn btn-danger',
                  'data' => [
                      'confirm' => 'Are you sure you want to delete this item?',
                      'method' => 'post',
                  ],
              ]) ?>
            <?php endif?>
        <!-- <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['delete', 'id' => $model->transaksi_id, 'idmtr'=>$model->motor->motor_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
        <?php if($model->isPaid()):?>
            <?= Html::a('Bukti Pembayaran', ['/kwitansi/view', 'id' => $model->kwitansi->kwitansi_id], [
                'class' => 'btn btn-primary'
            ]) ?>
        <?php else:?>
            <?= Html::a('Invoice', ['/invoice/view', 'id' => $model->invoice->invoice_id], [
                'class' => 'btn btn-info'
            ]) ?>
        <?php endif?>
    </p>
    <hr />
    <div class="row">
          <div class="container-fluid">
              <div class="panel panel-default">
                  <div class="panel-heading"><strong><?php echo Yii::t('app', 'Ubah Status');?></strong></div>
                  <div class="panel-body">
                      <div class="well col-lg-4">
                          <p>
                              Status Bayar:
                          </p>
                              <?php if($model->isPaid() && $model->isPicked()):?>
                                  <a class="tombol btn btn-warning disabled" style="width:150px;" href="<?= Url::toRoute(['transaksi/earn', 'id'=>$model->transaksi_id]);?>">Sudah Dibayar</a>
                              <?php elseif($model->isPaid()):?>
                                  <a class="tombol btn btn-warning" style="width:150px;" href="<?= Url::toRoute(['transaksi/earn', 'id'=>$model->transaksi_id, 'idkw'=>$model->kwitansi->kwitansi_id]);?>">Sudah Dibayar</a>
                              <?php else:?>
                                  <a class="tombol btn btn-primary" style="width:150px;" href="<?= Url::toRoute(['transaksi/paidoff', 'id'=>$model->transaksi_id]);?>">Belum Dibayar</a>
                              <?php endif?>
                      </div>

                      <?php if($model->isPaid()):?>
                      <div class="well col-lg-4">
                          <p>
                              Status Ambil:
                          </p>
                              <?php if($model->isPicked() && $model->isReturned()):?>
                                  <a class="tombol btn btn-warning disabled" style="width:150px;" href="<?= Url::toRoute(['transaksi/untake', 'id'=>$model->transaksi_id, 'idmtr'=>$model->motor->motor_id]);?>">Belum</a>
                              <?php elseif($model->isPicked()):?>
                                  <a class="tombol btn btn-warning" style="width:150px;" href="<?= Url::toRoute(['transaksi/untake', 'id'=>$model->transaksi_id, 'idmtr'=>$model->motor->motor_id]);?>">Belum</a>
                              <?php else:?>
                                  <a class="tombol btn btn-primary" style="width:150px;" href="<?= Url::toRoute(['transaksi/take', 'id'=>$model->transaksi_id, 'idmtr'=>$model->motor->motor_id]);?>">Diambil</a>
                              <?php endif?>
                      </div>
                      <?php endif?>

                      <?php if($model->isPaid()):?>
                      <div class="well col-lg-4">
                          <p>
                              Jaminan:
                          </p>
                              <?php if ($model->jaminan_status == Transaksi::STATUS_KTP && $model->isReturned()):?>
                                  <a class="btn btn-warning disabled" style="width:150px;" href="<?= Url::toRoute(['transaksi/nothing', 'id'=>$model->transaksi_id]);?>">Belum</a>
                              <?php elseif ($model->jaminan_status == Transaksi::STATUS_KTM && $model->isReturned()):?>
                                  <a class="btn btn-warning disabled" style="width:150px;" href="<?= Url::toRoute(['transaksi/nothing', 'id'=>$model->transaksi_id]);?>">Belum</a>
                              <?php elseif ($model->jaminan_status == Transaksi::STATUS_PERPUS && $model->isReturned()):?>
                                  <a class="btn btn-warning disabled" style="width:150px;" href="<?= Url::toRoute(['transaksi/nothing', 'id'=>$model->transaksi_id]);?>">Belum</a>
                              <?php elseif ($model->jaminan_status == Transaksi::STATUS_KTP) :?>
                                  <a class="btn btn-warning" style="width:150px;" href="<?= Url::toRoute(['transaksi/nothing', 'id'=>$model->transaksi_id]);?>">Belum</a>
                              <?php elseif ($model->jaminan_status == Transaksi::STATUS_KTM)   :?>
                                  <a class="btn btn-warning" style="width:150px;" href="<?= Url::toRoute(['transaksi/nothing', 'id'=>$model->transaksi_id]);?>">Belum</a>
                              <?php elseif ($model->jaminan_status == Transaksi::STATUS_PERPUS)   :?>
                                  <a class="btn btn-warning" style="width:150px;" href="<?= Url::toRoute(['transaksi/nothing', 'id'=>$model->transaksi_id]);?>">Belum</a>
                              <?php else :?>
                                  <a class="btn btn-primary" style="width:75px;" href="<?= Url::toRoute(['transaksi/ktp', 'id'=>$model->transaksi_id]);?>">KTP</a>
                                  <a class="btn btn-primary" style="width:75px;" href="<?= Url::toRoute(['transaksi/ktm', 'id'=>$model->transaksi_id]);?>">KTM</a>
                                  <a class="btn btn-primary" style="width:75px;" href="<?= Url::toRoute(['transaksi/perpus', 'id'=>$model->transaksi_id]);?>">Perpus</a>
                              <?php endif?>
                      </div>
                      <?php endif?>

                      <?php if($model->isPaid() && $model->isPicked()):?>
                      <div class="well col-lg-4">
                          <p>
                              Status Kembali:
                          </p>
                              <?php if($model->isReturned() && $model->isConfirmed()):?>
                                  <a class="btn btn-warning disabled" style="width:150px;" href="<?= Url::toRoute(['transaksi/unreturn', 'id'=>$model->transaksi_id, 'idmtr'=>$model->motor->motor_id]);?>">Belum</a>
                              <?php elseif($model->isReturned()):?>
                                  <a class="btn btn-warning" style="width:150px;" href="<?= Url::toRoute(['transaksi/unreturn', 'id'=>$model->transaksi_id, 'idmtr'=>$model->motor->motor_id]);?>">Belum</a>
                              <?php elseif(!$model->isReturned()):?>
                                  <a class="btn btn-primary" style="width:150px;" href="<?= Url::toRoute(['transaksi/return', 'id'=>$model->transaksi_id, 'idmtr'=>$model->motor->motor_id]);?>">Dikembalikan</a>
                              <?php endif?>
                      </div>
                      <?php endif?>

                      <?php if($model->isPaid() && $model->isPicked() && $model->isReturned()):?>
                      <div class="well col-lg-4">
                          <p>
                              Status Transaksi:
                          </p>
                              <?php if($model->isConfirmed()):?>
                                  <!-- <span class="label label-warning" >Unconfirm</span> -->
                                  <?php if(!empty($model->profit->profit_id)):?>
                                      <a class="btn btn-warning" style="width:150px;" href="<?= Url::toRoute(['transaksi/unconfirm', 'id'=>$model->transaksi_id, 'idprf'=>$model->profit->profit_id]);?>">Belum</a>
                                  <?php else:?>
                                      <a class="btn btn-warning" style="width:150px;" href="<?= Url::toRoute(['transaksi/inconfirm', 'id'=>$model->transaksi_id]);?>">Belum</a>
                                  <?php endif?>
                              <?php else:?>
                                  <a class="btn btn-primary" style="width:150px;" href="<?= Url::toRoute(['transaksi/confirm', 'id'=>$model->transaksi_id]);?>">Selesai</a>
                              <?php endif?>
                      </div>
                      <?php endif?>

                      <?php if($model->isReturned() && $model->status == 0):?>
                          <?php if(empty($model->denda->denda_id)):?>
                              <div class="well col-lg-4">
                                  <p>
                                      Denda:
                                  </p>
                                <?= Html::a('<span class="glyphicon glyphicon-money"></span>Buat Denda', ['/denda/create', 'id' => $model->transaksi_id], ['class' => 'btn btn-primary']) ?>
                          <?php endif?>
                      <?php endif?>
                      </div>
                  </div>
              </div>
          </div>
    </div>
    <hr />

    <div class="row">
      <div class="col-lg-4">
          <h3>Customer</h3>
          <?= DetailView::widget([
              'model' => $model,
              'attributes' => [
                  [
                      'attribute' => 'customer_id',
                      'label' => 'Username',
                      'value' => function($model) {
                          return $model->user->username;
                      }
                  ],
                  [
                      'attribute' => 'NIM',
                      'label' => 'NIM',
                      'value' => function($model) {
                          return $model->user->nim;
                      }
                  ],
                  [
                      'attribute' => 'customer_id',
                      'label' => 'Nama Lengkap',
                      'value' => function($model) {
                          return $model->user->profile->name;
                      }
                  ],
                  [
                      'attribute' => 'Email',
                      'value' => function($model) {
                          return $model->user->email;
                      }
                  ],
                  [
                      'attribute' => 'Kontak',
                      'label' => 'No. Handphone',
                      'value' => function($model) {
                          return $model->user->phone;
                      }
                  ],
                  [
                      'attribute' => 'Asrama',
                      'value' => function($model) {
                          return $model->user->asrama;
                      }
                  ],
                  [
                      'attribute' => 'Program Studi',
                      'value' => function($model) {
                          return $model->user->prodi;
                      }
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
                        'label' => 'Pengambilan',
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
                            } elseif ($model->jaminan_status == Transaksi::STATUS_PERPUS) {
                                return '<span class="label label-success">Perpus</span>';
                            } else {
                                return '<span class="label label-danger">Belum</span>';
                            }
                        }
                    ],
                    [
                        'attribute' => 'pengembalian_status',
                        'label' => 'Pengembalian',
                        'format' => 'html',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function($model) {
                            if (!empty($model->pengembalian_status == 1)) {
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
            ])?>
      </div>

      <div class="col-lg-4">
          <h3>Detail Reservasi</h3>
          <?= DetailView::widget([
              'model' => $model,
              'attributes' => [
                  'transaksi_id',
                  'motor_id',
                  'duration',
                  'paket.title',
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
                  'transaksi_created_at',
                  'transaksi_updated_at',
                  'payment:currency'
              ],
          ]) ?>
      </div>

      <div class="col-lg-4">
          <h3>Motor</h3>
          <div class="card">
              <div class="view overlay hm-white-light">
                  <img src="<?= Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->motor->gambar?>" width="350" style="padding:1rem;">
                  <div class="mask"></div>
              </div>
              <div class="card-body">
                  <!-- <h4 class="text-center"><?= $model->motor->motor_name?></h4> -->
                  <h4 class="text-center"><?= Html::a($model->motor->motor_name, ['/motor/view', 'id' => $model->motor_id]) ?></h4>
                  <p class="card-text text-center">ID Motor: <?= $model->motor->motor_id?></p>
              </div>
          </div>
      </div>
    </div>


    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Feedback');?></strong></div>
            <div class="panel-body">
              <?php if (!empty($model->feedback->feedback_id)) :?>
                  <?=$model->feedback->note?>
              <?php else :?>
                  <span class="label label-danger">Tidak Ada</span>
              <?php endif?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Denda');?></strong>
              <?php if (!empty($model->denda->denda_id)) :?>
                  <?php if($model->denda->isPayed()):?>
                      <span class="label label-success">Lunas</span>
                  <?php else:?>
                      <span class="label label-danger">Belum Bayar</span>
                  <?php endif?>

                  <?= Html::a('Detail', ['/denda/view', 'id' => $model->denda->denda_id], ['class' => 'pull-right label label-default']) ?>
              <?php endif?>
            </div>
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
                    <?php if($model->denda->isPayed()):?>
                        <span class="label label-success">Lunas</span>
                    <?php else:?>
                        <span class="label label-danger">Belum Bayar</span>
                    <?php endif?>

                    <span class="pull-right"><?= Yii::$app->formatter->asCurrency($model->denda->charge)?></span>
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
