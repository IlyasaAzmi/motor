<?php
// _list_history.php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Transaksi;
?>
<?php
if(empty($model->motor_id)):
    $model->delete();
endif
?>

<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-4">
                <?php if(!empty($model->motor_id)):?>
                    <img src="<?= Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->motor->gambar?>" width="300" height="auto">
                <?php else:?>
                    <span class="label label-danger">Motor Belum Dipilih</span>
                <?php endif ?>
            </div>
            <div class="col-md-8">
                <h2><?=$model->transaksi_id?></h2>
                <div class="pull-right">
                    <?=Html::encode(Yii::$app->formatter->asCurrency($model->payment))?>
                    <?php if ($model->payment_status == Transaksi::STATUS_PAIDOFF) :?>
                        <span class="label label-info">
                            <?=Html::encode('Lunas')?>
                        </span>
                    <?php else:?>
                        <span class="label label-danger">
                            <?=Html::encode('Belum')?>
                        </span>
                    <?php endif?>
                </div>

                <?php if ($model->status == 1) {?>
                    <span class="label label-success">Sukses</span>
                <?php } else { ?>
                    <span class="label label-warning">Proses</span>
                <?php }?>
                <hr>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Waktu Ambil</th>
                            <th>Durasi</th>
                            <th>Paket</th>
                            <th>Waktu Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <b><?= Yii::$app->formatter->asDatetime($model->transaksi_start_date)?></b>
                            </td>
                            <td>
                                <b><?= $model->duration?></b>
                            </td>
                            <td>
                                <b><?= $model->paket->title?></b>
                            </td>
                            <td>
                                <b><?= Yii::$app->formatter->asDatetime($model->transaksi_return_date)?></b>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>
                <div class="text-left">
                    <a href="<?=Url::to(['/transaksi/detail','id'=>$model->transaksi_id])?>" class="btn btn-elegant">Detail</a>

                    <?php if ($model->status == 1) {?>
                        <?php if (empty($model->feedback->feedback_id)) {?>
                          <a href="<?=Url::to(['/feedback/create','id'=>$model->transaksi_id])?>" class="btn btn-default">Feedback</a>
                        <?php }?>
                    <?php }?>

                    <!-- <?php if ($model->pengambilan_status == 1 && $model->pengembalian_status == 0) {?>
                        <a href="<?=Url::to(['/transaksi/extend','id'=>$model->transaksi_id])?>" class="btn btn-warning">Perpanjang</a>
                    <?php } ?> -->
                </div>
                <div class="text-right">
                    <span class="label label-default">
                    Transaksi dilakukan:
                    <?= Yii::$app->formatter->asDate($model->transaksi_updated_at, 'php:d-M-Y')?></span>
                </div>
            </div>
        </div>
    </div>
</div>
