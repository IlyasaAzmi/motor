<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Kwitansi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kwitansi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kwitansi_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transaksi_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fee')->textInput() ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
