<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Contributor */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contributors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contributor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->contributor_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->contributor_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <hr />
    <div class="container-fluid">
        <div class="well text-center col-lg-8 col-lg-offset-2">
          Ubah Status :
          <?php if($model->isActived()):?>
              <a class="btn btn-warning" href="<?= Url::toRoute(['contributor/inactive', 'id'=>$model->contributor_id]);?>">Non-Aktif</a>
              <?php else:?>
                  <a class="btn btn-success" href="<?= Url::toRoute(['contributor/active', 'id'=>$model->contributor_id]);?>">Aktif</a>
              <?php endif?>
        </div>
    </div>
    <hr />
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'contributor_id',
            'name',
            'phone',
            'email',
            [
                'attribute' => 'status',
                'label' => 'Status Transaksi',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->status == 1) {
                        return '<span class="label label-success">Aktif</span>';
                    } else {
                        return '<span class="label label-danger">Non Aktif</span>';
                    }
                }
            ],
        ],
    ]) ?>

</div>
