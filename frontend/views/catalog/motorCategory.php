<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;


$this->title = 'Motor U3';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <div class="col-lg-10"><br />
        <?php foreach($motors as $item) { ?>
            <div class="col-md-3 wow fadeIn">
                <div class="card">
                    <div class="view overlay hm-white-light">
                        <a href="?r=catalog%2Fview&id=<?php echo $item['motor_id']?>">
                        <img src="<?php echo Yii::getAlias('@motorImgUrl').'/'.'motor'.$item['gambar']?>" class="img-fluid" alt="">
                        <div class="mask"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center"><?php echo $item['title']?></p>
                        <!-- <div class="text-center"><a href="?r=catalog%2Fview&id=<?php echo $item['motor_id']?>" class="btn btn-elegant">Detail</a></div> -->
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="col-lg-2">
        <h2>Category</h2>
        <?php $items=[];
            foreach($categories as $category){
            $items[]=['label' => $category->title , 'url' => '#'];
            }
            echo Nav::widget([
            'items' => $items
        ]);?>
    </div>
</div>
