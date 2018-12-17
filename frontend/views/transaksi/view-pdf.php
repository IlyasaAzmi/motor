<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */

$this->title = 'Kode Transaksi : ' .$model->transaksi_id;
?>
<div class="transaksi-pdf">
    <div class="col-lg-12" align="center">
        <?php echo Html::img('@web/img/logoU3.png', ['class' => 'float-left img-responsive', "width"=>"100px"]); ?>
    </div>

    <h2 align="center">Bukti Transaksi</h2>
    <h3><?= Html::encode($this->title) ?></h3>

    <div class="col-md-12" align="center">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'paket.title',
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
                'transaksi_start_date:datetime',
                'transaksi_return_date:datetime',
                'duration',
                'payment:currency',
            ],
        ]) ?>
    </div>
    <br /><br />
    <div class="col-md-12" align="center">
        <img src="<?= Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->motor->gambar?>" width="200">
        <h4 align="center"><?= $model->motor->motor_name?></h4>
        <p align="center">ID Motor: <?= $model->motor->motor_id?></p>
    </div>

</div>
