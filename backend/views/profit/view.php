<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Profit */

$this->title = $model->profit_id;
$this->params['breadcrumbs'][] = ['label' => 'Profits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->profit_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->profit_id], [
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
            'profit_id',
            'transaksi_id',
            'profit',
            'sharing',
        ],
    ]) ?>

</div>
