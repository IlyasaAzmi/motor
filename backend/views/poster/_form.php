<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Poster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="poster-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'poster_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'gambar')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*',
                'multiple' => true
                ],
                'pluginOptions' => [
                    'allowedFileExtensions' => ['jpg','gif','png']
            ]]);?>
        </div>

        <div class="col-lg-6">
            <?php $oldImage = $model->gambar;
            if(isset($oldImage)){
                echo $model->title.' : poster'.$oldImage.'<br />';
                echo Html::img(Yii::getAlias('@posterImgUrl').'/'.'poster'.$model->gambar,['width'=>'550']);
            } ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
