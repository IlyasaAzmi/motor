<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Paket */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pakets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paket-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Yii::$app->session->getFlash('success');?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->paket_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->paket_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'paket_id',
            'title',
            'price',
            [
                'attribute'=>'gambar',
                'value'=> Yii::getAlias('@paketImgUrl').'/'.'paket'.$model->gambar,
                'format'=>['image',['width'=>'400','height'=>'auto']]
            ]
        ],
    ]) ?>

</div>
