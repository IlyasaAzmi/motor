<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Pilih Motor';
?>

<div class="reservasi-motor">
    <h2 class="text-center"><?= Html::encode($this->title) ?></h2>
    <p>Hai <?= Html::encode($model->customer) ?>, anda menentukan waktu (paket hari) sebagai berikut:</p>

    <!-- <ul>
        <li><label>Tanggal Awal</label>: <?= Html::encode($model->start_date) ?></li>
        <li><label>Durasi</label>: <?= Html::encode($model->duration) ?></li>
        <li><label>Pengembalian</label>: <?= Html::encode($model->return_date) ?></li>
        <li><label>Biaya</label>: <?= Html::encode($model->payment) ?></li>
    </ul> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode',
            // 'start_date:datetime',
            'start_date',
            'duration',
            'return_date',
            // 'return_date:datetime',
            'payment:currency',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

    <div class="text-center">
        <?= Html::a('Kembali', ['date-form'], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="row">
        <div class="divider-new pt-1">
            <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s">Motor Tersedia</h2>
        </div>
    </div>

    <div class="col-lg-12">
      <?php foreach ($motor as $key => $value) { ?>
          <div class="col-sm-3">
              <div class="card">
                  <div class="view overlay hm-white-light">
                      <a href="?r=catalog%2Fview&id=<?php echo $value['motor_id']?>">
                          <img src="<?php echo Yii::getAlias('@motorImgUrl').'/'.'motor'.$value['gambar']?>" class="img-fluid">
                              <div class="card-body">
                              <p class="card-text text-center">
                                  <?php echo $value['title']?>
                              </p>
                              </div>
                          <div class="mask"></div>
                      </a>
                  </div>
              </div>
          </div>
      <?php }?>
    </div>

</div>
