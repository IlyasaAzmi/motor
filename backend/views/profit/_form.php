<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Profit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'transaksi_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profit')->textInput() ?>

    <?= $form->field($model, 'sharing')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
