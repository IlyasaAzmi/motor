<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use common\models\Transaksi;
//use common\models\Paket;

$this->title = 'Masa Sewa';
$this->params['breadcrumbs'][] = $this->title;

?>


<br>

<div class="transaksi-date">

    <div class="row">

        <!-- <div class="col-lg-4">
            <img src="http://localhost/motor/images/2-masa.png" class="img-fluid" width=220 height=auto alt="">
        </div>

        <div class="col-lg-4">
            <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s">1. Paket Reservasi</h2>
        </div> -->

        <div class="col-lg-4">
            <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s">2. <?= Html::encode($this->title) ?></h2>

            <br>

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'transaksi_start_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'tanggal mulai sewa'],
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]);?>

            <?= $form->field($model, 'duration')->dropDownList($model->durasiHari(),[
              'class' => 'form-control', 'prompt' => '-Tentukan Durasi-'
              ]) ?>

            <br>

            <div class="form-group">
                <?= Html::submitButton('Cari Motor', ['class' => 'btn btn-default']) ?>
                <a href="?r=transaksi%2Fpaket" class="btn btn-danger pull-right">Kembali Pilih Paket</a>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>

</div>
