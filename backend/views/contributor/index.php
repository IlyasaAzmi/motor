<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContributorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contributors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contributor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Buat Contributor Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-striped table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'contributor_id',
            'name',
            'phone',
            'email:email',
            [
                'header' => 'Jumlah Motor',
                'content' => function ($model, $key, $index, $column) {
                    $title = sprintf('Motor (%d)', $model->motorsCount);
                    return Html::a($title, ['motor/grids', 'Motor[contributor_id]' => $model->contributor_id]);
                }
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'filter'=>array("0"=>"Non Aktif","1"=>"Aktif"),
                'value' => function($model) {
                    if ($model->status == 1) {
                        return '<span class="label label-primary">Aktif</span>';
                    } else {
                        return '<span class="label label-danger">Non-Aktif</span>';
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
                        ['view', 'id' => $model['contributor_id']],
                        ['title' => 'View', 'id' => 'modal-btn-view']);
                  	},
                  	'update' => function($id, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-primary"><b class="glyphicon glyphicon-pencil"></b></span>',
                        ['update', 'id' => $model['contributor_id']],
                        ['title' => 'Update', 'id' => 'modal-btn-view']);
                  	},
                  	'delete' => function($url, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-danger"><b class="glyphicon glyphicon-trash"></b></span>',
                        ['delete', 'id' => $model['contributor_id']],
                        ['title' => 'Delete',
                        'class' => '',
                        'data' => ['confirm' => 'Are you absolutely sure ? You will lose all the information about this transaksi with this action.',
                        'method' => 'post', 'data-pjax' => false],
                        ]);
                  	}
                ]
            ],
        ],
    ]); ?>

    <?php
    $gridColumns = [
        'contributor_id',
        'name',
        'phone',
        'email',
        'motorsCount',
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
                            'SetHeader' => ['Manajemen Contributor'],
                        ],
                    ],
                ],
            ],
            'filename' => 'manajemen-contributor',
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
