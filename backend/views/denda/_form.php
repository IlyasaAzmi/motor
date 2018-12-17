<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model common\models\Denda */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="denda-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dendaform',
        'options' => [
            'enctype'=>'multipart/form-data',
            'class' => 'form-horizontal',
            ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <!-- <?= $form->field($model, 'transaksi_id')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'tipe')->textInput() ?> -->
    <?= $form->field($model, 'tipe')->dropDownList($model->tipeDenda(),[
      'class' => 'form-control', 'prompt' => '-Tentukan Tipe Denda-'
      ]) ?>

    <!-- <?= $form->field($model, 'charge')->textInput() ?> -->
    <?= $form->field($model, 'charge')->widget(NumberControl::classname(), [
        'maskedInputOptions' => [
            'prefix' => 'Rp ',
            // 'suffix' => ' ¢',
            'allowMinus' => false
        ],
        // 'options' => $saveOptions,
        // 'displayOptions' => $dispOptions,
        // 'saveInputContainer' => $saveCont
    ]);?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <!-- <?= $form->field($model, 'created_at')->textInput() ?> -->

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
