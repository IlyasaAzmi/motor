<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */

$this->title = 'Reservasi Bulan';
$this->params['breadcrumbs'][] = ['label' => 'Transaksis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-jam">

<?php if ($transaksis != 0):?>
    <div class="panel panel-danger">
        <div class="panel-heading"><?= Html::encode('Maaf') ?></div>
        <div class="panel-body">
            <?= Html::encode('Silahkan menyelesaikan reservasi yang sudah dilakukan untuk melakukan reservasi baru') ?><br />
            <?= Html::encode('Terima kasih') ?>
        </div>
    </div>
    <h2><?= Html::encode('Proses Reservasi') ?><br /></h2>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        // 'tag' => 'div',
        'class' => 'list-wrapper',
        'id' => 'list-wrapper',
        'layout' => "{pager}\n{summary}\n{items}",
        'itemView' => '_list_rent',
    ]); ?>

<?php elseif ($transaksis == 0):?>
    <h2 class="text-center"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_bulanform', [
        'model' => $model,
        'motor' => $motor,
        'paket' => $paket,
        'motors' => $motors,
    ]) ?>

<?php endif?>
</div>
