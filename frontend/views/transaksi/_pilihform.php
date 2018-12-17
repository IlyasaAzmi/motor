<<?php
use yii\helpers\Url;
?>

<div class="col-lg-12">
    <?php foreach($motor as $item) { ?>
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 wow fadeIn" data-wow-delay="0.2s">
            <div class="card">
                <div class="view overlay hm-white-light">
                    <a href="?r=catalog%2Fview&id=<?php echo $item['motor_id']?>">
                    <img src="<?php echo Yii::getAlias('@motorImgUrl').'/'.'motor'.$item['gambar']?>" class="img-fluid" style="padding:1rem;" alt="">
                    <div class="mask"></div>
                    </a>
                </div>
                <div class="card-body">
                    <p class="card-text text-center"><?php echo $item['motor_name']?></p>
                    <div class="text-center" value="<?$item['gambar']?>">
                      <a href="<?= Url::to(['transaksi/plh','idmtr'=>$item['motor_id']]);?>
                      " class="btn btn-default">Pilih</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
