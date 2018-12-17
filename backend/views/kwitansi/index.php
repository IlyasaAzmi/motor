<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\KwitansiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kwitansis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kwitansi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Kwitansi', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kwitansi_id',
            'transaksi_id',
            'fee:currency',
            'note',
            'created_at:datetime',
            // 'staf_id',
            // 'user.username',
            [
                'attribute' => 'staf_id',
                'label' => 'Staf',
                'value' => function($model) {
                    return $model->user->username;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
