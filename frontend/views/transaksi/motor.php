<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

// date_default_timezone_set("Asia/Jakarta");

/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */

$this->title = 'Pilih Motor Tersedia';
// $this->params['breadcrumbs'][] = ['label' => 'Transaksis', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => 'Jam', 'url' => ['jam']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-motor">

    <!-- <h2 class="text-center"><?= Html::encode($this->title) ?></h2> -->
    <h2 class="text-center"><?= Html::encode('Waktu Reservasi') ?></h2>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'transaksi_start_date:date',
                // 'transaksi_start_date:time',
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

                'duration',
                'paket.title',
                // 'transaksi_return_date:date',
                // 'transaksi_return_date:time',
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
                'payment:currency',
            ],
        ]) ?>
        </div>
    </div>

    <div class="row text-center">
        <?= Html::a('Kembali Tentukan Waktu', ['clear','id' => $model->transaksi_id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Anda yakin ingin menentukan waktu kembali?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Cancel Reservasi', ['cancel','id' => $model->transaksi_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Anda yakin ingin membatalkan reservasi?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <br />
    <hr />

    <h2 class="text-center"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_motorform', [
        'model' => $model,
        'motor' => $motor,
        'paket' => $paket,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
