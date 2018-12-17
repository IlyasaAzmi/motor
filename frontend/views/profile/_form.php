<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nim',['options'=>['class'=>'col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone',['options'=>['class'=>'col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_id',['options'=>['class'=>'col-md-12']])->textInput() ?>

    <?= $form->field($model, 'fakultas_id',['options'=>['class'=>'col-md-6']])->textInput() ?>

    <?= $form->field($model, 'prodi_id',['options'=>['class'=>'col-md-6']])->textInput() ?>

    <?= $form->field($model, 'ktm',['options'=>['class'=>'col-md-12']])->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
