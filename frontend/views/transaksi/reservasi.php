<?php
use yii\helpers\Html;

$this->title = 'Pilih Paket Reservasi';
 ?>

<h2 class="text-center">Pilih Paket Reservasi</h2>
<div class="row text-center">
    <?= Html::a('Jam', ['jam'], ['class' => 'btn btn-default']) ?>
    <?= Html::a('Harian', ['create'], ['class' => 'btn btn-default']) ?>
    <?= Html::a('Mingguan', ['minggu'], ['class' => 'btn btn-default']) ?>
    <?= Html::a('Bulanan', ['bulan'], ['class' => 'btn btn-default']) ?>
</div>
