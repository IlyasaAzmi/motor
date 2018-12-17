<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use dosamigos\ckeditor\CKEditor;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'blog_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'text')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'en',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

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
                echo $model->title.' : blog'.$oldImage.'<br />';
                echo Html::img(Yii::getAlias('@blogImgUrl').'/'.'blog'.$model->gambar,['width'=>'300']);
            } ?>
        </div>
    </div>

    <?php
    echo $form->field($model, 'status')->radioList([
        '0' => Yii::t('app', 'Pending'),
        '1' => Yii::t('app', 'Publish'),
        ], ['itemOptions' => ['class' =>'radio-inline','labelOptions'=>array('style'=>'padding:4px;')]])->label('');
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
