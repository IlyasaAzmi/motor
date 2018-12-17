<?php

use yii\helpers\Html;
use yii\grid\GridView;

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'blog_id',
            'title',
            // 'text:ntext',
            // [
            //     'attribute' => 'text',
            //     'format' => 'html',
            //     'contentOptions' =>
            //         ['style ' => 'max-width: 350px; overflow:auto; word-wrap:break-word;'],
            //     'value' => function($model){
            //     return Html::tag('div', $model->text,[
            //     'style' => "max-width: 350px; word-wrap:break-word;"
            //         ]);
            //     }
            // ],
            // 'slug',
            // 'gambar',
            [
                'attribute' => 'gambar',
                'label' => 'Gambar',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if (!empty($model->gambar)) {
                        return $model->gambar;
                    } else {
                        return '<span class="label label-warning">Tidak Ada</span>';
                    }
                }
            ],
            // 'status',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    if ($model->status == 1) {
                        return '<span class="label label-primary">Publish</span>';
                    } else {
                        return '<span class="label label-warning">Pending</span>';
                    }
                }
            ],
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'buttons' => [
                    'view' => function($url, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-default"><b class="glyphicon glyphicon-zoom-in"></b></span>',
                        ['view', 'id' => $model['blog_id']],
                        ['title' => 'View', 'id' => 'modal-btn-view']);
                  	},
                  	'update' => function($id, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-primary"><b class="glyphicon glyphicon-pencil"></b></span>',
                        ['update', 'id' => $model['blog_id']],
                        ['title' => 'Update', 'id' => 'modal-btn-view']);
                  	},
                  	'delete' => function($url, $model) {
                  	    return Html::a('<span class="btn btn-sm btn-danger"><b class="glyphicon glyphicon-trash"></b></span>',
                        ['delete', 'id' => $model['blog_id']],
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
</div>
