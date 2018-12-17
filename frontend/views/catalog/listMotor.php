<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;


$this->title = 'Daftar Motor';

$this->params['breadcrumbs'][] = ['label' => 'Katalog', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="list-motor">
    <div class="col-lg-10">
        <h2 class="text-center"><?= Html::encode($this->title) ?></h2>
        <?php foreach ($motor as $key => $value) { ?>
            <div class="col-sm-3">
                <div class="card">
                    <div class="view overlay hm-white-light">
                        <a href="?r=catalog%2Fview&id=<?php echo $value['motor_id']?>">
                            <img src="<?php echo Yii::getAlias('@motorImgUrl').'/'.'motor'.$value['gambar']?>" class="img-fluid">
                                <div class="card-body">
                                <p class="card-text text-center">
                                    <b><?php echo $value['motor_name']?></b>
                                </p>
                                <p class="card-text text-center">
                                    <?php echo $value['motor_id']?>
                                </p>
                                </div>
                            <div class="mask"></div>
                        </a>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>

    <div class="col-lg-2">
        <h2>Kategori</h2>
        <?php $items=[];
            foreach($categories as $category){
            $items[]=['label' => $category->title , 'url' => Yii::$app->homeUrl.'?r=catalog%2Flistbycat&id='.$category->kategori_id ];
          }
            echo Nav::widget([
            'items' => $items
        ]);?>
    </div>

</div>
