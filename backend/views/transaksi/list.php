<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Transaksi List';
?>

<div class="motor-list">
    <!-- <?= $count;?> -->
    <h3><?= $this->title?></h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Motor ID</th>
                <!-- <th>Motor</th> -->
                <th>User ID</th>
                <!-- <th>Username</th> -->
                <th>Duration</th>
                <th>Paket</th>
                <!-- <th>Mulai</th>
                <th>Kembali</th> -->
                <th>Biaya</th>
                <th>Action</th>
                <th>Action Pembayaran</th>
                <th>Action Pengambilan</th>
                <th>Action Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($transaksis as $transaksi):?>
            <tr>
                <td><?= $transaksi->transaksi_id?></td>
                <td><?= $transaksi->motor_id?></td>
                <!-- <td><?= $transaksi->motor->motor_name?></td> -->
                <td><?= $transaksi->user->id?></td>
                <!-- <td><?= $transaksi->user->username?></td> -->
                <td><?= $transaksi->duration?></td>
                <td><?= $transaksi->paket->title?></td>
                <!-- <td><?= Yii::$app->formatter->asDate($transaksi->transaksi_start_date, 'php:d-M-Y')?></td>
                <td><?= Yii::$app->formatter->asDate($transaksi->transaksi_return_date, 'php:d-M-Y')?></td> -->
                <td><?= $transaksi->payment?></td>
                <td>
                    <?php if($transaksi->isConfirmed()):?>
                        <!-- <span class="label label-warning" >Unconfirm</span> -->
                        <a class="label label-warning" href="<?= Url::toRoute(['transaksi/unconfirm', 'id'=>$transaksi->transaksi_id]);?>">Unconfirm</a>
                        <?php else:?>
                            <a class="label label-success" href="<?= Url::toRoute(['transaksi/confirm', 'id'=>$transaksi->transaksi_id]);?>">Confirm</a>
                        <?php endif?>
                    <!-- <a class="btn btn-danger" href="<?= Url::toRoute(['transaksi/delete', 'id'=>$transaksi->transaksi_id]);?>">Delete</a>
                    <a class="btn btn-info" href="<?= Url::toRoute(['transaksi/view', 'id'=>$transaksi->transaksi_id]);?>">Detail</a> -->
                </td>
                <td>
                    <?php if($transaksi->isPaid()):?>
                        <a class="label label-warning" href="<?= Url::toRoute(['transaksi/earn', 'id'=>$transaksi->transaksi_id]);?>">Belum</a>
                        <?php else:?>
                            <a class="label label-success" href="<?= Url::toRoute(['transaksi/paidoff', 'id'=>$transaksi->transaksi_id]);?>">Lunas</a>
                        <?php endif?>
                </td>
                <td>
                    <?php if($transaksi->isPicked()):?>
                        <a class="label label-warning" href="<?= Url::toRoute(['transaksi/untake', 'id'=>$transaksi->transaksi_id]);?>">Belum</a>
                        <?php else:?>
                            <a class="label label-success" href="<?= Url::toRoute(['transaksi/take', 'id'=>$transaksi->transaksi_id]);?>">Ambil</a>
                        <?php endif?>
                </td>
                <td>
                    <?php if($transaksi->isReturned()):?>
                        <a class="label label-warning" href="<?= Url::toRoute(['transaksi/unreturn', 'id'=>$transaksi->transaksi_id]);?>">Belum</a>
                        <?php else:?>
                            <a class="label label-success" href="<?= Url::toRoute(['transaksi/return', 'id'=>$transaksi->transaksi_id]);?>">Kembali</a>
                        <?php endif?>
                </td>

            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
