<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TransaksiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'History';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        // 'tag' => 'div',
        'class' => 'list-wrapper',
        'id' => 'list-wrapper',
        'layout' => "{pager}\n{summary}\n{items}",
        'itemView' => '_list_history',
    ]); ?>
</div>
