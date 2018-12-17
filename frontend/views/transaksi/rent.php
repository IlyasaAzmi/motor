<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TransaksiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Rent';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-index">
    <h2><?= Html::encode($this->title) ?></h2>
    <h2><?= Html::encode($query->id) ?></h2>
    <h2><?= Html::encode($query->transaksisCount) ?></h2>
    <h2><?= Html::encode($transaksis) ?></h2>

    <?php if ($transaksis != 0):?>
        <?= Html::encode('Sudah ada transaksi aktif') ?></h2>
    <?php elseif ($transaksis == 0):?>
        <?= Html::encode('Silahkan melakukan transaksi') ?></h2>
    <?php endif?>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        // 'tag' => 'div',
        'class' => 'list-wrapper',
        'id' => 'list-wrapper',
        'layout' => "{pager}\n{summary}\n{items}",
        'itemView' => '_list_rent',
    ]); ?>
</div>
