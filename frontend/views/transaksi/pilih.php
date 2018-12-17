<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<p>You have entered the following information:</p>

<ul>
    <li><label>Start</label>: <?= Html::encode($model->start) ?></li>
    <li><label>Duration</label>: <?= Html::encode($model->duration) ?></li>
</ul>
<?php


// date_default_timezone_set("Asia/Jakarta");

/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */

$this->title = 'Pilih Motor';
// $this->params['breadcrumbs'][] = ['label' => 'Transaksis', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => 'Jam', 'url' => ['jam']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-motor">

    <!-- <h2 class="text-center"><?= Html::encode($this->title) ?></h2> -->
    <h2 class="text-center"><?= Html::encode('Waktu Reservasi') ?></h2>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'transaksi_start_date:date',
                // 'transaksi_start_date:time',
                [
                    'attribute' => 'transaksi_start_date',
                    'label' => 'Tanggal Ambil',
                    'value' => Yii::$app->formatter->asDateTime($model->start)
                ],

                'duration',
                // 'paket.title',
                // 'transaksi_return_date:date',
                // 'transaksi_return_date:time',
                // [
                //     'attribute' => 'transaksi_return_date',
                //     'label' => 'Tanggal Kembali',
                //     'value' => Yii::$app->formatter->asDate($model->transaksi_return_date)
                // ],
                // [
                //     'attribute' => 'transaksi_return_date',
                //     'label' => 'Jam Kembali',
                //     'value' => Yii::$app->formatter->asTime($model->transaksi_return_date)
                // ],
                // 'payment:currency',
            ],
        ]) ?>
        </div>
    </div>


    <br />
    <hr />
    <h2 class="text-center"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_pilihform', [
        'model' => $model,
        'transaksi' => $transaksi,
        'motor' => $motor,
    ]) ?>

</div>
