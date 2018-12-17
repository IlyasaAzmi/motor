<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Denda */

$this->title = 'Buat Denda';
$this->params['breadcrumbs'][] = ['label' => 'Dendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="denda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
