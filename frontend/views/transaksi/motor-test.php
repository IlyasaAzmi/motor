<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use common\models\Transaksi;
use common\models\Paket;

$this->title = 'Pilih Motor';
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $model common\models\Transaksi */
/* @var $form yii\widgets\ActiveForm */
?>


<br>

<div class="transaksi-motor">

    <div class="row">

        <div class="col-lg-4">
            <img src="http://localhost/motor/images/3-motor.png" class="img-fluid" width=220 height=auto alt="">
        </div>

        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s">1. Paket Reservasi</h2>
                    <p>Paket</p>
                </div>

                <div class="col-lg-6">
                    <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s">2. Masa Sewa</h2>
                        <ul>
                            <li>Waktu Pengambilan:       Jam:</li>
                            <li>Durasi: </li>
                            <li>Waktu Kembal:       Jam:</li>
                            <li>Jam: </li>
                        </ul>
                    <br>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="divider-new pt-1">
                        <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s">3. Motor</h2>
                    </div>
                </div>

                <?php foreach($motors as $item) { ?>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 wow fadeIn" data-wow-delay="0.2s">
                        <div class="card">
                            <div class="view overlay hm-white-light">
                                <img src="<?php echo Yii::getAlias('@motorImgUrl').'/'.'motor'.$item['gambar']?>" class="img-fluid" width=200 height="auto" alt="">
                                <div class="mask"></div>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-center"><?php echo $item['motor_name']?></p>
                                <div class="text-center"><a href="?r=transaksi%2Fcreate" class="btn btn-default">Pilih</a></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="text-center">
                    <a href="?r=transaksi%2Fpaket" class="btn btn-warning pull-left"> << Kembali Pilih Paket</a>
                    <a href="?r=transaksi%2Fdate" class="btn btn-warning pull-right"> << Kembali Penentuan Waktu</a>
                </div>
            </div>

        </div>


    </div>

</div>
