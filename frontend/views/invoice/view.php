<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Invoice */

$this->title = $model->invoice_id;
// $this->params['breadcrumbs'][] = ['label' => 'Detail Transaksi', 'url' => ['/transaksi/detail', 'id' => $model->transaksi_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->invoice_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->invoice_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Detail Transaksi', ['/transaksi/detail', 'id' => $model->transaksi_id], ['class' => 'btn btn-info pull-right']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'invoice_id',
            'transaksi_id',
            'bill:currency',
            'created_at:datetime',
        ],
    ]) ?>

</div>
