<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
// use jino5577\daterangepicker\DateRangePicker; //daterange picker widget

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TransaksiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manajemen Transaksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Status Transaksi');?></strong></div>
            <div class="panel-body text-center">
                <a class="btn btn-success" href="<?= Url::toRoute(['transaksi/confirmed']);?>">Sukses <span class="badge"><?= $confirmed;?></span></a>
                <a class="btn btn-warning" href="<?= Url::toRoute(['transaksi/unconfirmed']);?>">Proses <span class="badge"><?= $unconfirmed;?></span></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Pembayaran');?></strong></div>
            <div class="panel-body text-center">
                <a class="btn btn-info" href="<?= Url::toRoute(['transaksi/paidoffed']);?>">Lunas <span class="badge"><?= $paidoff;?></span></a>
                <a class="btn btn-danger" href="<?= Url::toRoute(['transaksi/earned']);?>">Tunggakan <span class="badge"><?= $earn;?></span></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Pengambilan');?></strong></div>
            <div class="panel-body text-center">
                <a class="btn btn-default" href="<?= Url::toRoute(['transaksi/untaked']);?>">Belum Diambil <span class="badge"><?= $untaked;?></span></a>
                <a class="btn btn-primary" href="<?= Url::toRoute(['transaksi/ongoing']);?>">Sewa <span class="badge"><?= $ongoing;?></span></a>
            </div>
        </div>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!-- <?= Html::a('Create Transaksi', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-striped table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'transaksi_id',
            [
                'attribute' => 'transaksi_id',
                'label' => 'Kode Reservasi',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->status == 1) {
                        return '<span class="label label-success">'.$model->transaksi_id.'</span>';
                    } else {
                        return '<span class="label label-warning">'.$model->transaksi_id.'</span>';
                    }
                }
            ],
            // 'motor_id',
            // [
            //     'class' => 'yii\grid\DataColumn',
            //     'attribute'=>'motor_id',
            //     'value'=>'motor.motor_name',
            // ],

            // [
            //     'attribute' => 'motor_id',
            //     'label' => 'Motor',
            //     'format' => 'html',
            //     'headerOptions' => ['class' => 'text-center'],
            //     // 'contentOptions' => ['class' => 'text-center'],
            //     'value' => function($model) {
            //         return $model->motor_id.'-'.$model->motor->motor_name;
            //     }
            // ],

            [
                'attribute' => 'motor_id',
                'header' => 'Motor',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'value' => 'motor.motor_name',
                'content' => function ($model, $key, $index, $column) {
                    if(!empty($model->motor_id)):
                        $title = sprintf($model->motor_id.'-'.$model->motor->motor_name);
                    else:
                        $title = '<span class="label label-danger">'.Html::encode('Belum dipilih').'</span>';
                    endif;
                    return Html::a($title, ['/motor/view', 'id' => $model->motor_id]);
                }
            ],

            [
                'class' => 'yii\grid\DataColumn',
                'attribute'=>'customer_id',
                'contentOptions' => ['class' => 'text-center'],
                'value' => 'user.username'
            ],
            // 'duration',
            [
                'attribute' => 'duration',
                'label' => 'Durasi',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    return $model->duration;
                }
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute'=>'paket_id',
                'filter'=>array("Jam"=>"Jam","Hari"=>"Hari","Minggu"=>"Minggu","Bulan"=>"Bulan"),
                'value' => 'paket.title'
            ],
            // 'transaksi_start_date:datetime',
            // 'transaksi_start_date:time',
            // 'transaksi_start_date:datetime',
            // 'transaksi_return_date',
            [
                'attribute' => 'payment',
                'label' => 'Biaya',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->payment_status == 1) {
                        return '<span class="label label-info">'.Yii::$app->formatter->asCurrency($model->payment).'</span>';
                    } else {
                        return '<span class="label label-danger">'.Yii::$app->formatter->asCurrency($model->payment).'</span>';
                    }
                }
            ],

            // DATE RANGE PICKER
            // [
          	// 		// the attribute
          	// 		'attribute' => 'transaksi_created_at',
          	// 		// format the value
          	// 		// 'value' => function ($model) {
          	// 		// 	if (extension_loaded('intl')) {
            // 		// 			// return Yii::t('app', '{0, date, MMMM dd, YYYY HH:mm}', [$model->transaksi_created_at]);
            //     //       return Yii::t('app', '{0, date, MMMM dd, YYYY HH:mm}', $_GET[$model->transaksi_created_at]);
          	// 		// 	} //else {
            // 		// 			// return date('Y-m-d G:i:s', $model->transaksi_created_at);
            // 		// 			return date('Y-m-d G:i:s', $_GET[$model->transaksi_created_at]);
          	// 		// 	// }
          	// 		// },
          	// 		// some styling?
          	// 		'headerOptions' => [
          	// 			'class' => 'col-md-2'
          	// 		],
          	// 		// here we render the widget
          	// 		'filter' => DateRangePicker::widget([
          	// 			'model' => $searchModel,
          	// 			'attribute' => 'transaksi_created_at_range',
          	// 			'pluginOptions' => [
          	// 			'format' => 'Y-m-d',
          	// 			'autoUpdateInput' => false
          	// 		]
          	// 		])
        		// ],

            //'transaksi_created_at',
            // 'transaksi_updated_at',
            // [
            //     'attribute' => 'payment_status',
            //     'label' => 'Pembayaran',
            //     'format' => 'html',
            //     'headerOptions' => ['class' => 'text-center'],
            //     'contentOptions' => ['class' => 'text-center'],
            //     'value' => function($model) {
            //         if ($model->payment_status == 1) {
            //             return '<span class="label label-info">Lunas</span>';
            //         } else {
            //             return '<span class="label label-danger">Belum</span>';
            //         }
            //     }
            // ],
            // [
            //     'attribute' => 'status',
            //     'label' => 'Status',
            //     'format' => 'html',
            //     'headerOptions' => ['class' => 'text-center'],
            //     'contentOptions' => ['class' => 'text-center'],
            //     'value' => function($model) {
            //         if ($model->status == 1) {
            //             return '<span class="label label-success">Berhasil</span>';
            //         } else {
            //             return '<span class="label label-warning">Proses</span>';
            //         }
            //     }
            // ],

            // ['class' => 'yii\grid\ActionColumn'],
            // 'transaksi_created_at:date',
            [
                'attribute' => 'transaksi_created_at',
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->transaksi_created_at, 'short');
                },
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'transaksi_created_at',
                    'options' => ['placeholder' => 'Tanggal'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}{delete}',
                'buttons' => [
                    'view' => function($url, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-default"><b class="glyphicon glyphicon-zoom-in"></b></span>',
                        ['view', 'id' => $model['transaksi_id']],
                        ['title' => 'View', 'id' => 'modal-btn-view']);
                  	},
                  	'update' => function($id, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-default"><b class="fa fa-pencil"></b></span>',
                        ['update', 'id' => $model['transaksi_id']],
                        ['title' => 'Update', 'id' => 'modal-btn-view']);
                  	},
                  	'delete' => function($url, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-danger"><b class="glyphicon glyphicon-trash"></b></span>',
                        ['delete', 'id' => $model['transaksi_id'], 'idmtr' => $model->motor->motor_id],
                        ['title' => 'Delete',
                        'class' => '',
                        'data' => ['confirm' => 'Are you absolutely sure ? You will lose all the information about this transaksi with this action.',
                        'method' => 'post', 'data-pjax' => false],
                        ]);
                  	}
                ]
            ]
        ],
    ]); ?>

    <p>
        <?php
        $gridColumns = [
            'transaksi_id',
            'motor_id',
            'motor.motor_name',
            'customer_id',
            'user.username',
            'duration',
            'paket.title',
            'transaksi_start_date',
            'transaksi_return_date',
            'transaksi_created_at',
            'transaksi_updated_at',
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
                                'SetHeader' => ['Manajemen Transaksi'],
                            ],
                        ],
                    ],
                ],
                'filename' => 'manajemen-transaksi',
                'dropdownOptions' => [
                  'label' => Yii::t('app', 'Export Data'),
                  'class' => 'btn btn-primary',
                ],
                'columnSelectorOptions' => [
                  'class' => 'btn btn-primary',
                ],
            ]);
        ?>
    </p>

</div>
