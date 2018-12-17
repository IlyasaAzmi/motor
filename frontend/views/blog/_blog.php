<?php
use yii\helpers\Url;
 ?>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-4">
                <img src="<?php echo Yii::getAlias('@blogImgUrl').'/'.'blog'.$model->gambar?>" width="300" height="auto">
            </div>
            <div class="col-md-8">

                <h2><?=$model->title?></h2>
                <hr>
                <p>
                    <?=$model->text?>
                </p>

                <hr>
                <div class="text-left">
                    <a href="<?=Url::to(['/blog/view','id'=>$model->slug])?>" class="btn btn-default">Baca Selengkapnya</a>
                </div>
                <div class="text-right">
                    <span><?= Yii::$app->formatter->asDate($model->updated_at, 'php:d-M-Y')?></span>
                </div>
            </div>
        </div>
    </div>
</div>
