<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\Motor;

/* @var $this yii\web\View */
/* @var $model common\models\Motor */

$this->title = $model->motor_name.' - '.$model->motor_id;
$this->params['breadcrumbs'][] = ['label' => 'Motors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="motor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Yii::$app->session->getFlash('success');?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->motor_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->motor_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Anda yakin ingin menghapus motor ini?',
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('Generate PDF', ['gen-pdf', 'id' => $model->motor_id], ['class' => 'btn btn-info pull-right']) ?>
    </p>
    <hr />
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><strong><?php echo Yii::t('app', 'Ubah Status');?></strong></div>
                <div class="panel-body">
                  <div class="well col-md-6">
                    <p>
                        Ubah Status :
                    </p>
                    <?php if($model->isActived()):?>
                        <a class="btn btn-warning text-center" href="<?= Url::toRoute(['motor/inactive', 'id'=>$model->motor_id]);?>">Non-Aktif</a>
                        <?php else:?>
                            <a class="btn btn-success text-center" href="<?= Url::toRoute(['motor/active', 'id'=>$model->motor_id]);?>">Aktif</a>
                        <?php endif?>
                  </div>

                  <div class="well col-md-6">
                    <p>
                      Ubah Kondisi :
                    </p>
                    <?php if ($model->current_status == Motor::CURRENT_STATUS_AVAILABLE) :?>
                        <a class="btn btn-warning text-center" href="<?= Url::toRoute(['motor/booked', 'id'=>$model->motor_id]);?>">Booked</a>
                        <!-- <a class="btn btn-primary text-center" href="<?= Url::toRoute(['motor/onrent', 'id'=>$model->motor_id]);?>">On Rent</a> -->

                      <?php elseif ($model->current_status == Motor::CURRENT_STATUS_BOOKED):?>
                            <a class="btn btn-success text-center" href="<?= Url::toRoute(['motor/available', 'id'=>$model->motor_id]);?>">Available</a>
                            <a class="btn btn-primary text-center" href="<?= Url::toRoute(['motor/onrent', 'id'=>$model->motor_id]);?>">On Rent</a>

                            <?php elseif ($model->current_status == Motor::CURRENT_STATUS_ONRENT):?>
                                <a class="btn btn-success text-center" href="<?= Url::toRoute(['motor/available', 'id'=>$model->motor_id]);?>">Available</a>
                                <!-- <a class="btn btn-warning text-center" href="<?= Url::toRoute(['motor/booked', 'id'=>$model->motor_id]);?>">Booked</a> -->

                                <?php else:?>
                                    <a class="btn btn-success text-center" href="<?= Url::toRoute(['motor/available', 'id'=>$model->motor_id]);?>">Available</a>

                        <?php endif?>
                  </div>

                </div>
            </div>
        </div>


    </div>

    <!-- <p>
        Ubah Status :
        <?php if($model->isActived()):?>
            <a class="btn btn-warning" href="<?= Url::toRoute(['motor/inactive', 'id'=>$model->motor_id]);?>">Non-Aktif</a>
            <?php else:?>
                <a class="btn btn-success" href="<?= Url::toRoute(['motor/active', 'id'=>$model->motor_id]);?>">Aktif</a>
            <?php endif?>
    </p> -->

    <div class="col-md-8">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'motor_id',
                'plat',
                'year',
                'motor_name',
                'kategori.title',
                'contributor.name',
                'start_date:date',
                'expired_date:date',
                // [
                //     'attribute'=>'gambar',
                //     'value'=> Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->gambar,
                //     'contentOptions' => ['class' => 'text-center'],
                //     'format'=>['image',['width'=>'400','height'=>'auto']]
                // ],
                // 'entrust_type',
                [
                    'attribute' => 'entrust_type',
                    'label' => 'Tipe Penitipan',
                    'format' => 'html',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function($model) {
                        if ($model->entrust_type == 70) {
                            return 'Rasio 70:30';
                        } elseif ($model->entrust_type == 50) {
                            return 'Rasio 50:50';
                        } elseif ($model->entrust_type == 100) {
                            return 'Full';
                        } else {
                            return 'Belum Ditentukan';
                        }
                    }
                ],
                // 'status',
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'format' => 'html',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function($model) {
                        if ($model->status == 1) {
                            return '<span class="label label-success">Aktif</span>';
                        } else {
                            return '<span class="label label-danger">Tidak Aktif</span>';
                        }
                    }
                ],

                [
                    'attribute' => 'current_status',
                    'label' => 'Kondisi',
                    'format' => 'html',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function($model) {
                        if ($model->current_status == Motor::CURRENT_STATUS_AVAILABLE) {
                            return '<span class="label label-success">Available</span>';
                        } elseif ($model->current_status == Motor::CURRENT_STATUS_BOOKED) {
                            return '<span class="label label-warning">Booked</span>';
                        } elseif ($model->current_status == Motor::CURRENT_STATUS_ONRENT) {
                            return '<span class="label label-primary">On Rent</span>';
                        } else {
                            return '<span class="label label-default">Pending</span>';
                        }
                    }
                ],
            ],
        ]) ?>
    </div>


    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 wow fadeIn">
        <div class="card">
            <div class="view overlay hm-white-light">
                <img src="<?= Yii::getAlias('@motorImgUrl').'/'.'motor'.$model->gambar?>" class="img-fluid" style="padding:1rem; width:350px;">
                <div class="mask"></div>
            </div>
            <div class="card-body">
                <h4 class="text-center"><?= $model->motor_name?></h4>
                <p class="card-text text-center">ID Motor: <?= $model->motor_id?></p>
            </div>
        </div>
    </div>

</div>
