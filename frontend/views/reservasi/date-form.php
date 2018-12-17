<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

$this->title = 'Waktu Reservasi';
?>

<div class="reservasi-waktu">
    <h2 class="text-center"><?= Html::encode($this->title) ?></h2>
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'start_date',['options'=>['class'=>'col-md-6']])->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => '-- Waktu Pengambilan Motor --'],
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'todayBtn' => true,
                'format' => 'yyyy/mm/dd hh:ii',
            ]
        ]);?>

        <?= $form->field($model, 'duration',['options'=>['class'=>'col-md-6']])->dropDownList($model->durasiHari(),[
            'class' => 'form-control', 'prompt' => '-- Tentukan Durasi --'
            ]) ?>

        <div class="form-group text-center">
            <?= Html::submitButton('Cari Motor', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
