<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
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

<div class="transaksi-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'enableAjaxValidation'=>true]); ?>

    <?= $form->field($model, 'motor_id')->dropDownList($motor, ['prompt' => '- Pilih Motor -'])?>

    <?= $form->field($model, 'transaksi_start_date')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Waktu Pengambilan Motor ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'yyyy/mm/dd hh:ii',
        ]
    ]);?>

    <?= $form->field($model, 'duration')->dropDownList($model->durasiHari(),[
      'class' => 'form-control', 'prompt' => '-Tentukan Durasi-'
      ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
