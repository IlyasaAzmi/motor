<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feedbacks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Feedback', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'feedback_id',
            // 'transaksi_id',
            [
                'attribute' => 'transaksi_id',
                'label' => 'Reservasi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'content' => function ($model, $key, $index, $column) {
                    $title = sprintf($model->transaksi_id);
                    return Html::a($title, ['/transaksi/view', 'id' => $model->transaksi_id]);
                }
            ],
            [
                'attribute' => 'motor_id',
                'label' => 'Motor',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'content' => function ($model, $key, $index, $column) {
                    $title = sprintf($model->transaksi->motor->motor_name);
                    return Html::a($title, ['/motor/view', 'id' => $model->transaksi->motor_id]);
                }
            ],
            'note:ntext',
            'created_at:date',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
