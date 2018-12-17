<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if(!empty($blogs)):?>

        <table class="table">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Title</td>
                    <td>Slug</td>
                    <td>Gambar</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($blogs as $blog):?>
                    <tr>
                        <td><?= $blog->blog_id?></td>
                        <td><?= $blog->title?></td>
                        <td><?= $blog->slug?></td>
                        <td><?= $blog->gambar?></td>
                        <td>
                            <?php if($blog->isAllowed()):?>
                                <a class="btn btn-warning" href="<?= Url::toRoute(['blog/disallow', 'id'=>$blog->blog_id]);?>">Disallow</a>
                                <?php else:?>
                                    <a class="btn btn-success" href="<?= Url::toRoute(['blog/allow', 'id'=>$blog->blog_id]);?>">Allow</a>
                                <?php endif?>
                            <a class="btn btn-danger" href="<?= Url::toRoute(['blog/delete', 'id'=>$blog->blog_id]);?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>

        </table>
    <?php endif;?>
</div>
