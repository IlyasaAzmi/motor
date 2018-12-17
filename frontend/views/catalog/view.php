<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Motor */

$this->title = $model->motor_name.' - '.$model->motor_id;
$this->params['breadcrumbs'][] = ['label' => 'Katalog', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="motor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 wow fadeIn">
        <div class="card">
            <div class="view overlay hm-white-light">
                <img src="<?= Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->gambar?>" class="img-fluid" style="padding:1rem;">
                <div class="mask"></div>
            </div>
            <div class="card-body">
                <h4 class="text-center"><?= $model->motor_name?></h4>
                <p class="card-text text-center">ID Motor: <?= $model->motor_id?></p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'motor_id',
                'motor_name',
                'kategori.title',
                'year',
                // [
                //     'attribute'=>'gambar',
                //     'value'=> Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->gambar,
                //     'format'=>['image',['width'=>'400','height'=>'auto']]
                // ]
            ],
        ]) ?>
    </div>

</div>
