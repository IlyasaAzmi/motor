<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use yii\helpers\Url;
// use jino5577\daterangepicker\DateRangePicker; //daterange picker widget


/* @var $this yii\web\View */
/* @var $searchModel backend\models\MotorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manajemen Motor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="motor-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Status Motor');?></strong></div>
            <div class="panel-body text-center">
                <a class="btn btn-primary" href="<?= Url::toRoute(['motor/actived']);?>">Motor Aktif <span class="badge"><?= $actived;?></span></a>
                <a class="btn btn-danger" href="<?= Url::toRoute(['motor/inactived']);?>">Motor Non-Aktif <span class="badge"><?= $inactived;?></span></a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo Yii::t('app', 'Kondisi');?></strong></div>
            <div class="panel-body text-center">
                <a class="btn btn-default" href="<?= Url::toRoute(['motor/added']);?>">Pending <span class="badge"><?= $added;?></span></a>
                <a class="btn btn-success" href="<?= Url::toRoute(['motor/availabled']);?>">Available <span class="badge"><?= $availabled;?></span></a>
                <a class="btn btn-warning" href="<?= Url::toRoute(['motor/book']);?>">Booked <span class="badge"><?= $booked;?></span></a>
                <a class="btn btn-primary" href="<?= Url::toRoute(['motor/onrented']);?>">On Rent <span class="badge"><?= $onrented;?></span></a>
            </div>
        </div>
    </div>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Buat Motor Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php

        Modal::begin([
        'header' => '<h4>HEADER</h4>',
        'id' => 'model',
        'size' => 'model-lg',
        ]);

        echo "<div id='modelContent'></div>";

        Modal::end();

    ?>



    <?php Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-striped table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'motor_id',
            'plat',
            'motor_name',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute'=>'kategori_id',
                'filter'=>array("Skuter Matic"=>"Skuter Matic","Bebek"=>"Bebek"),
                'value'=>'kategori.title',
            ],
            [
                'attribute'=>'contributor_id',
                'value'=>'contributor.name',
            ],

            // [
            //     'attribute'=>'start_date',
            //     'value'=>'start_date',
            //     'format'=>'raw',
            //     'filter'=> DatePicker::widget([
            //         'name' => 'dp_3',
            //         'model' => $searchModel,
            //         'attribute' => 'start_date',
            //         'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //         'pluginOptions' => [
            //             'autoclose'=>true,
            //             'format' => 'yyyy-mm-dd',
            //             'todayHighlight' => true,
            //         ]
            //     ])
            // ],
            // [
            //     'attribute'=>'expired_date',
            //     'filter'=> DatePicker::widget([
            //         'name' => 'dp_3',
            //         'model' => $searchModel,
            //         'attribute' => 'expired_date',
            //         'type' => DatePicker::TYPE_COMPONENT_APPEND,
            //         'pluginOptions' => [
            //             'autoclose'=>true,
            //             'format' => 'yyyy-mm-dd',
            //             'todayHighlight' => true,
            //         ]
            //     ])
            // ],

            // DATE RANGE PICKER WIDGET
            // [
          	// 		// the attribute
          	// 		'attribute' => 'start_date',
          	// 		// format the value
          	// 		'value' => function ($model) {
          	// 			if (extension_loaded('intl')) {
          	// 				return Yii::t('app', '{0, date, MMMM dd, YYYY HH:mm}', [$model->start_date]);
          	// 			} else {
          	// 				return date('Y-m-d G:i:s', $model->start_date);
          	// 			}
          	// 		},
          	// 		// some styling?
          	// 		'headerOptions' => [
          	// 			'class' => 'col-md-2'
          	// 		],
          	// 		// here we render the widget
          	// 		'filter' => DateRangePicker::widget([
          	// 			'model' => $searchModel,
          	// 			'attribute' => 'start_date_range',
          	// 			'pluginOptions' => [
          	// 			'format' => 'd-m-Y',
          	// 			'autoUpdateInput' => false
          	// 		]
          	// 		])
        		// ],

            // [
            //     'attribute' => 'gambar',
            //     'format' => ['image',
            //         ['width'=>'40','height'=>'auto']],
            //     'label' => 'Foto',
            //     'value' => function ($data) {
            //         return Yii::getAlias('@motorImgUrl').'/'.'motor'.$data->gambar;
            //     }
            // ],

            [
                'header' => 'Jumlah Transaksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'content' => function ($model, $key, $index, $column) {
                    $title = sprintf('(%d)', $model->transaksisCount);
                    return Html::a($title, ['transaksi/grids', 'Transaksi[motor_id]' => $model->motor_id]);
                }
            ],

            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'filter'=>array("0"=>"Tidak Aktif","1"=>"Aktif"),
                'value' => function($model) {
                    if ($model->status == 1) {
                        return '<span class="label label-info">Aktif</span>';
                    } else {
                        return '<span class="label label-danger">Tidak Aktif</span>';
                    }
                }
            ],

            [
                'attribute' => 'current_status',
                'label' => 'Kondisi',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'filter'=>array("0"=>"Added","10"=>"Available","20"=>"Booked","30"=>"On Rent"),
                'value' => function($model) {
                    if ($model->current_status == 10) {
                        return '<span class="label label-success">Available</span>';
                    } elseif ($model->current_status == 20) {
                        return '<span class="label label-warning">Booked</span>';
                    } elseif ($model->current_status == 30) {
                        return '<span class="label label-primary">On Rent</span>';
                    } else {
                        return '<span class="label label-default">Pending</span>';
                    }
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'buttons' => [
                    'view' => function($url, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-default"><b class="glyphicon glyphicon-zoom-in"></b></span>',
                        ['view', 'id' => $model['motor_id']],
                        ['title' => 'View', 'id' => 'modal-btn-view']);
                  	},
                  	'update' => function($id, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-primary"><b class="glyphicon glyphicon-pencil"></b></span>',
                        ['update', 'id' => $model['motor_id']],
                        ['title' => 'Update', 'id' => 'modal-btn-view']);
                  	},
                  	'delete' => function($url, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-danger"><b class="glyphicon glyphicon-trash"></b></span>',
                        ['delete', 'id' => $model['motor_id']],
                        ['title' => 'Delete',
                        'class' => '',
                        'data' => ['confirm' => 'Are you absolutely sure ? You will lose all the information about this motor with this action.',
                        'method' => 'post', 'data-pjax' => false],
                        ]);
                  	}
                ]
            ],
        ],
        'options'=>['class'=>'grid-view gridview-newclass'],
    ]); ?>
    <?php Pjax::end();?>

    <?php
    $gridColumns = [
        'motor_id',
        'plat',
        'motor_name',
        'kategori.title',
        'contributor.name',
        'start_date',
        'expired_date'
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
                            'SetHeader' => ['Manajemen Motor'],
                        ],
                    ],
                ],
            ],
            'filename' => 'manajemen-motor',
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
