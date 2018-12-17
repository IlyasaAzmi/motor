<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Denda Kerusakan';
$this->params['breadcrumbs'][] = ['label' => 'Denda', 'url' => ['/denda/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="denda-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Denda', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php $total = 0;

    foreach($dataProvider->models as $m)
    {
       $total += $m->charge;
    }?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'denda_id',
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
            // 'tipe',
            [
                'attribute' => 'tipe',
                'label' => 'Tipe Denda',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->tipe == 10) {
                        return 'Keterlambatan';
                    } elseif ($model->tipe == 20) {
                        return 'Kerusakan';
                    } elseif ($model->tipe == 30) {
                        return 'Keterlambatan dan Kerusakan';
                    }
                }
            ],
            // 'charge:currency',
            [
                 'attribute' => 'charge',
                 'value' => function($data) {
                      return \Yii::$app->formatter->asCurrency($data->charge);
                 },
                 'footer' => '<b>'. \Yii::$app->formatter->asCurrency($total) .'</b>'
            ],

            'note:ntext',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
