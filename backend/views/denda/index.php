<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Denda';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="denda-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Tipe Denda');?></strong></div>
            <div class="panel-body text-center">
                <a class="btn btn-primary" href="<?= Url::toRoute(['denda/terlambat']);?>">Terlambat <span class="badge"><?= $terlambat;?></span></a>
                <a class="btn btn-warning" href="<?= Url::toRoute(['denda/kerusakan']);?>">Kerusakan <span class="badge"><?= $rusak;?></span></a>
                <a class="btn btn-danger" href="<?= Url::toRoute(['denda/terusak']);?>">Terlambat dan Kerusakan <span class="badge"><?= $terusak;?></span></a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Pembayaran Denda');?></strong></div>
            <div class="panel-body text-center">
                <a class="btn btn-success" href="<?= Url::toRoute(['denda/lunased']);?>">Lunas <span class="badge"><?= $lunased;?></span></a>
                <a class="btn btn-danger" href="<?= Url::toRoute(['denda/hutanged']);?>">Belum Bayar <span class="badge"><?= $hutanged;?></span></a>
            </div>
        </div>
    </div>

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
        'filterModel' => $searchModel,
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
                // 'value' => 'denda.transaksi.motor.motor_name',
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

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'buttons' => [
                    'view' => function($url, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-default"><b class="glyphicon glyphicon-zoom-in"></b></span>',
                        ['view', 'id' => $model['denda_id']],
                        ['title' => 'View', 'id' => 'modal-btn-view']);
                  	},
                  	'update' => function($id, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-primary"><b class="glyphicon glyphicon-pencil"></b></span>',
                        ['update', 'id' => $model['denda_id']],
                        ['title' => 'Update', 'id' => 'modal-btn-view']);
                  	},
                  	'delete' => function($url, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-danger"><b class="glyphicon glyphicon-trash"></b></span>',
                        ['delete', 'id' => $model['denda_id']],
                        ['title' => 'Delete',
                        'class' => '',
                        'data' => ['confirm' => 'Are you absolutely sure ? You will lose all the information about this denda with this action.',
                        'method' => 'post', 'data-pjax' => false],
                        ]);
                  	}
                ]
            ],
        ],
    ]); ?>

    <?php
    $gridColumns = [
        'denda_id',
        'transaksi_id',
        'tipe',
        'charge',
        'note',
        'bayar_status',
        'created_at'
    ];

    //Renders a export dropdown menu
    echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_CSV => false,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_PDF => [
                    'pdfConfig' => [
                        'methods' => [
                            'SetHeader' => ['Manajemen Denda'],
                        ],
                    ],
                ],
            ],
            'filename' => 'manajemen-denda',
            'dropdownOptions' => [
              'label' => Yii::t('app', 'Export Data'),
              'class' => 'btn btn-primary',
            ],
            'columnSelectorOptions' => [
              'class' => 'btn btn-primary',
            ],
        ]);
    ?>

</div>
