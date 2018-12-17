<?php
use yii\helpers\Html;


$this->title = 'Paket Reservasi';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="col-lg-4">
        <img src="http://localhost/motor/images/1-paket.png" class="img-fluid" width=220 height=:"auto" alt="">
    </div>

    <div class="col-lg-8">
        <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s"><?= Html::encode($this->title) ?></h2>
        <br>

        <?php foreach($pakets as $item) { ?>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 wow fadeIn" data-wow-delay="0.2s">
                <div class="card">
                    <div class="view overlay hm-white-light">
                        <img src="<?php echo Yii::getAlias('@paketImgUrl').'/'.'paket'.$item['gambar']?>" class="img-fluid" width=300 height="auto" alt="">
                        <div class="mask"></div>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center">@<?php echo $item['title']?></p>
                        <p class="card-text text-center"><strong><?php echo Yii::$app->formatter->asCurrency ($item['price'], 'Rp')?></strong></p>
                        <div class="text-center"><a href="?r=transaksi%2Fdate" class="btn btn-default">Pilih</a></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
