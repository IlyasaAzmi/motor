<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Motor */

$this->title = 'Update Motor: ' . $model->motor_name;
$this->params['breadcrumbs'][] = ['label' => 'Motors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->motor_name, 'url' => ['view', 'id' => $model->motor_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="motor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'kategori' => $kategori
    ]) ?>

</div>
