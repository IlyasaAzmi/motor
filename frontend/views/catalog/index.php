<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;


$this->title = 'Katalog';
$this->params['breadcrumbs'][] = $this->title;

?>
<h2><?= Html::encode($this->title) ?></h2>

<div class="list-motor">
    <!-- <div class="col-lg-10">

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
    </div> -->

    <!-- <div class="col-lg-2">
        <h2>Kategori</h2>
        <?php $items=[];
            foreach($categories as $category){
            $items[]=['label' => $category->title , 'url' => Yii::$app->homeUrl.'?r=catalog%2Flistbycat&id='.$category->kategori_id ];
          }
            echo Nav::widget([
            'items' => $items
        ]);?>
    </div> -->

    <div class="col-lg-10">
        <?=
            ListView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'tag' => 'div',
                    'class' => 'list-wrapper',
                    'id' => 'list-wrapper',
                ],
                'layout' => "{pager}\n{summary}\n{items}",
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_list_item',['model' => $model]);

                    // or just do some echo
                    // return $model->title . ' posted by ' . $model->author;
                },
            ]);
        ?>
    </div>

    <div class="col-lg-2">
    <h4><?= Html::encode('Filter Pencarian') ?></h3>
        <div class="motor-form">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'],
            ]); ?>

            <?= $form->field($searchModel, 'motor_name') ?>

            <?= $form->field($searchModel, 'kategori_id')->dropDownList(
            [
                'Bebek' => Yii::t('app', 'Bebek'),
                'Skuter Matic' => Yii::t('app', 'Skuter Matic'),
            ],
            [
                'prompt'=>Yii::t('app', 'Semua')
            ]);
            ?>

            <div class="form-group">
                <?= Html::submitButton('Apply', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
