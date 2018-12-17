<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Motor */

$this->title = $model->motor_name;
// $this->params['breadcrumbs'][] = ['label' => 'Motors', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="motor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'motor_id',
            'plat',
            'motor_name',
            'kategori.title',
            'contributor.name',
            'start_date:date',
            'expired_date:date',
            [
                'attribute'=>'gambar',
                'value'=> Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->gambar,
                'format'=>['image',['width'=>'400','height'=>'auto']]
            ],
            // 'status:boolean',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->status == 1) {
                        return '<span class="label label-success">Aktif</span>';
                    } else {
                        return '<span class="label label-danger">Tidak Aktif</span>';
                    }
                }
            ],
        ],
    ]) ?>

</div>
