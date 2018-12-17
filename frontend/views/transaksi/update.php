<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */

$this->title = 'Update Transaksi: ' . $model->transaksi_id;
$this->params['breadcrumbs'][] = ['label' => 'Transaksis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->transaksi_id, 'url' => ['view', 'id' => $model->transaksi_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transaksi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'motor' => $motor,
        'paket' => $paket,
    ]) ?>

</div>
