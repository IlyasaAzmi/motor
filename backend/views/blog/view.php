<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <p>
        <?= Html::a('Update', ['update', 'id' => $model->blog_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->blog_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Status');?></strong>
              <?php if($model->isAllowed()):?>
                  <span class="label label-primary pull-right">Published</span>
              <?php else:?>
                  <span class="label label-warning pull-right">Pending</span>
              <?php endif?>
            </div>

            <div class="panel-body">
                <div class="well col-md-6">
                      Ubah Status :
                  <?php if($model->isAllowed()):?>
                      <a class="btn btn-warning text-center" href="<?= Url::toRoute(['blog/disallow', 'id'=>$model->blog_id]);?>">Pending</a>
                      <?php else:?>
                          <a class="btn btn-primary text-center" href="<?= Url::toRoute(['blog/allow', 'id'=>$model->blog_id]);?>">Publish</a>
                      <?php endif?>
                </div>
            </div>
        </div>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'blog_id',
            'title',
            'text:ntext',
            'slug',
            [
                'attribute'=>'gambar',
                'value'=> Yii::getAlias('@blogImgUrl').'/'.'blog'.$model->gambar,
                'format'=>['image',['width'=>'400','height'=>'auto']]
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
