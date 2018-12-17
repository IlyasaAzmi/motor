<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Kwitansi */

$this->title = $model->kwitansi_id;
// $this->params['breadcrumbs'][] = ['label' => 'Kwitansis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kwitansi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Update', ['update', 'id' => $model->kwitansi_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->kwitansi_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kwitansi_id',
            'transaksi_id',
            'fee:currency',
            'note',
            'created_at:datetime',
            // 'user.username',
            [
                'attribute' => 'staf_id',
                'label' => 'Tertanda Staf U3 Motor',
                'value' => function($model) {
                    return $model->user->username;
                }
            ]
        ],
    ]) ?>

</div>
