<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Contributor */

$this->title = 'Create Contributor';
$this->params['breadcrumbs'][] = ['label' => 'Contributors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contributor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
