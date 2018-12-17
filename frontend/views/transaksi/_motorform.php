<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="row">
    <div class="col-lg-12">
      <div class="col-lg-offset-2 col-lg-10">
          <h4><?= Html::encode('Filter Pencarian') ?></h3>
      </div>
          <div class="motor-form">
              <?php $form = ActiveForm::begin([
                  'method' => 'get',
                  // 'action' => ['index'],
                  'options' => [
                      'enctype'=>'multipart/form-data',
                      'class' => 'form-horizontal',
                      ],
                  'fieldConfig' => [
                      'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
                      'labelOptions' => ['class' => 'col-lg-2 control-label'],
                  ],
              ]); ?>

              <?= $form->field($searchModel, 'motor_name') ?>

              <?= $form->field($searchModel, 'kategori_id')->dropDownList(
              [
                  '2' => Yii::t('app', 'Bebek'),
                  '1' => Yii::t('app', 'Skuter Matic'),
              ],
              [
                  'prompt'=>Yii::t('app', 'Semua')
              ]);
              ?>

              <div class="form-group">
                  <div class="col-lg-offset-2 col-lg-10">
                  <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
                  </div>
              </div>

              <?php ActiveForm::end(); ?>
          </div>
    </div>


</div>

<div class="col-lg-12">
    <!-- <?php foreach($motor as $item) { ?>
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
                      <a href="<?= Url::to(['transaksi/mtr','id'=>$model->transaksi_id,'idmtr'=>$item['motor_id']]);?>
                      " class="btn btn-default">Pilih</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?> -->

    <!-- menampilkan listview -->
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'list-wrapper',
        ],
        'layout' => "{pager}\n{summary}\n{items}",
        'itemView' => '_list_motor',
        // 'itemView' => function ($model, $key, $index, $widget) {
        //     return $this->render('_list_motor',[
        //         'model' => $model,
        //     ]);
        //
        //
        //     // or just do some echo
        //     // return $model->title . ' posted by ' . $model->author;
        // },
        'viewParams'=>['transaksi'=>$model->transaksi_id],
    ]);
    ?>
</div>
