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
            'columns' => $gridColumns
        ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
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
                'value' => function($model) {
                    if ($model->status == 1) {
                        return '<span class="label label-primary">Aktif</span>';
                    } else {
                        return '<span class="label label-danger">Non-Aktif</span>';
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
