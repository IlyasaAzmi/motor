<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;


$this->title = 'Katalog Motor U3';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<br>
<div class="row">
    <div class="col-lg-2">
        <div class="widget-wrapper wow fadeIn" data-wow-delay="0.4s">
            <h4 class="font-bold">Kategori:</h4>
            <br>
            <div class="list-group">
                <a href="?r=catalog%2Fdaftar" class="list-group-item active">All</a>
                <a href="?r=catalog%2Fmatic" class="list-group-item">Skuter Matic</a>
                <a href="?r=catalog%2Fbebek" class="list-group-item">Bebek</a>
            </div>
        </div>
    </div>

    <div class="col-lg-10">
        <?php foreach($motors as $item) { ?>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 wow fadeIn" data-wow-delay="0.2s">
                <div class="card">
                    <div class="view overlay hm-white-light">
                        <a href="?r=catalog%2Fview&id=<?php echo $item['motor_id']?>">
                        <img src="<?php echo Yii::getAlias('@motorImgUrl').'/'.'motor'.$item['gambar']?>" class="img-fluid" alt="">
                        <div class="mask"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center"><?php echo $item['title']?></p>
                        <div class="text-center"><a href="?r=catalog%2Fview&id=<?php echo $item['motor_id']?>" class="btn btn-elegant">Detail</a></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
