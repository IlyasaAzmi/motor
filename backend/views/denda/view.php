<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Denda;

/* @var $this yii\web\View */
/* @var $model common\models\Denda */

$this->title = $model->denda_id;
// $this->params['breadcrumbs'][] = ['label' => 'Dendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="denda-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->denda_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->denda_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Ke Detail Transaksi', ['/transaksi/view', 'id' => $model->transaksi_id], ['class' => 'btn btn-info pull-right']) ?>
    </p>

    <div class="col-md-8">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'denda_id',
                'transaksi_id',
                'transaksi.motor_id',
                // 'tipe',
                [
                    'attribute' => 'tipe',
                    'label' => 'Tipe Denda',
                    'format' => 'html',
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
                'charge:currency',
                'note:ntext',
                // 'bayar_status',
                [
                    'attribute' => 'bayar_status',
                    'label' => 'Pelunasan',
                    'format' => 'html',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function($model) {
                        if ($model->bayar_status == Denda::DENDA_LUNAS) {
                            return '<span class="label label-success">Lunas</span>';
                        } else {
                            return '<span class="label label-danger">Belum</span>';
                        }
                    }
                ],
                'created_at',
            ],
        ]) ?>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Denda');?></strong>
              <?php if($model->isPayed()):?>
                  <?= Html::a('Lunas', ['/denda/view', 'id' => $model->denda_id], ['class' => 'pull-right label label-success']) ?>
              <?php else:?>
                  <?= Html::a('Hutang', ['/denda/view', 'id' => $model->denda_id], ['class' => 'pull-right label label-danger']) ?>
              <?php endif?>
            </div>
            <div class="panel-body">
              <?php if($model->isPayed()):?>
                  <?php if($model->receipt):?>
                      <?= Html::a('Belum Dibayar', ['/denda/hutang', 'id' => $model->denda_id, 'idkw' => $model->receipt->receipt_id], ['class' => 'pull-right btn btn-default']) ?>
                  <?php else :?>
                      <?= Html::a('Belum Dibayar', ['/denda/hutang', 'id' => $model->denda_id], ['class' => 'pull-right btn btn-default']) ?>
                  <?php endif?>
              <?php else :?>
                  <?= Html::a('Sudah Dibayar', ['/denda/lunas', 'id' => $model->denda_id], ['class' => 'pull-right btn btn-default']) ?>
              <?php endif?>
            </div>
        </div>
        <?php if($model->receipt):?>
            <?= Html::a('Detail Pembayaran', ['/receipt/view', 'id' => $model->receipt->receipt_id], ['class' => 'btn btn-primary']) ?>
        <?php endif?>
    </div>


</div>
