<?php
// _list_motor.php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="item" data-key="<?= $model->motor_id; ?>">
    <div class="col-sm-3">
        <div class="card">
            <div class="view overlay hm-white-light">
                <a href="?r=catalog%2Fview&id=<?php echo $model->motor_id?>">
                    <img src="<?= Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->gambar?>" class="img-fluid">
                    <div class="mask"></div>
                    </a>
                        <div class="card-body">
                            <p class="card-text text-center">
                                <?= Html::encode($model->motor_name); ?>
                            </p>
                            <p class="card-text text-center">
                                <?= Html::encode($model->motor_id); ?>
                            </p>
                            <div class="text-center" value="<?$model->gambar?>">
                                <a href="<?= Url::to(['transaksi/mtr','id'=>$transaksi,'idmtr'=>$model->motor_id]);?>
                                " class="btn btn-default">Pilih</a>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
