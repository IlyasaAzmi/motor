<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use common\models\Paket;
use common\models\Motor;
use common\models\Customer;

/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */
/* @var $form yii\widgets\ActiveForm */
?>
<h5 class="text-center">(Biaya Rp 30.000/hari)</h5>
<hr />
<div class="transaksi-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype'=>'multipart/form-data',
            'class' => 'form-horizontal',
            ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'transaksi_start_date')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Tanggal dan Jam Pengambilan'],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy/mm/dd hh:ii',
            // 'format' => 'dd/mm/yyyy hh:ii',
        ]
    ]);?>

    <?= $form->field($model, 'duration')->dropDownList($model->durasiHari(),[
      'class' => 'form-control', 'prompt' => '-Tentukan Durasi-'
      ]) ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton('Cari Motor', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
