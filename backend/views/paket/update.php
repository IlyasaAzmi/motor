<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Paket */

$this->title = 'Update Paket: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pakets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->paket_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
