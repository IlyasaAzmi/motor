<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use common\models\Kategori;
use common\models\Contributor;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\models\Motor */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="motor-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'motor_id',['options'=>['class'=>'col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plat',['options'=>['class'=>'col-md-3']])->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'year',['options'=>['class'=>'col-md-3']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'motor_name',['options'=>['class'=>'col-md-6']])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kategori_id',['options'=>['class'=>'col-md-3']])->dropDownList($kategori, ['prompt' => '- Pilih Kategori -'])?>

    <?= $form->field($model, 'contributor_id',['options'=>['class'=>'col-md-3']])->dropDownList(
        ArrayHelper::map(Contributor::find()->all(),'contributor_id','name'),
        ['prompt'=>'- Pilih Kontributor -']
    ) ?>

    <?= $form->field($model, 'start_date',['options'=>['class'=>'col-md-6']])->widget(DatePicker::classname(), [
        'options' => ['placeholder' => '- tanggal mulai penitipan -'],
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);?>

    <?= $form->field($model, 'expired_date',['options'=>['class'=>'col-md-6']])->widget(DatePicker::classname(), [
        'options' => ['placeholder' => '- tanggal selesai penitipan -'],
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'  ]
    ]);?>

    <div class="row">
        <?= $form->field($model, 'gambar',['options'=>['class'=>'col-md-6']])->widget(FileInput::classname(), [
            'language' => 'id',
            'options' => [
                'accept' => 'image/*',
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowedFileExtensions' => ['jpg','gif','png'],
                'browseLabel' => 'Pilih Gambar',
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i>',
        ]]);?>

        <?php $oldImage = $model->gambar;
        if(isset($oldImage)){
            echo $model->motor_name.' : motor'.$oldImage.'<br />';
            echo Html::img(Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->gambar,['width'=>'250']);
        } ?>
    </div>

    <?php
    echo $form->field($model, 'current_status')->radioList([
        '0' => Yii::t('app', 'Pending'),
        '10' => Yii::t('app', 'Available'),
        '20' => Yii::t('app', 'Booked'),
        '30' => Yii::t('app', 'On Rent'),
        ], ['itemOptions' => ['class' =>'radio-inline','labelOptions'=>array('style'=>'padding:4px;')]])->label('Tentukan kondisi motor');
    ?>

    <?php
    echo $form->field($model, 'entrust_type')->radioList([
        '70' => Yii::t('app', 'Rasio 70:30'),
        '50' => Yii::t('app', 'Rasio 50:50'),
        '100' => Yii::t('app', 'Full'),
      ], ['itemOptions' => ['class' =>'radio-inline','labelOptions'=>array('style'=>'padding:4px;')]])->label('Tentukan Tipe Penitipan');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ?
        'Create' : 'Update', [
            'class'=>$model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ])
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
