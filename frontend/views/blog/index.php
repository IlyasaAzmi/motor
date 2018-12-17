<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">
    <div class="container">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <br>
        <?= ListView::widget([
            'dataProvider' => $dt_blog,
            'itemView' => '_blog',
            'layout' => '<div class="row">{items}</div><div class="text-center">{pager}</div>',
        ]); ?>
    </div>
</div>
