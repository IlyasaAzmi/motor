<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Motor */

$this->title = 'Tes Generate PDF';
$this->params['breadcrumbs'][] = ['label' => 'Motors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-pdf">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('PDF', ['/mpdf/report'], ['class'=>'btn btn-primary']) ?>



</div>
