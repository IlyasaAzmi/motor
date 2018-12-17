<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\ProfitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profit-search">

    <h4><?= Html::encode('Filter Pencarian Tanggal') ?></h4>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php
                echo '<label class="control-label">'.Yii::t('app', 'Dari').'</label>';
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'start_date',
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'options' => [
                        'placeholder' => 'Tanggal Awal',
                    ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'todayHighlight' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
            ?>
        </div>

        <div class="col-sm-6">
        <?php
            echo '<label class="control-label">'.Yii::t('app', 'Ke').'</label>';
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'end_date',
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'options' => [
                    'placeholder' => 'Tanggal Akhir',
                ],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'todayHighlight' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ]);
        ?>
        </div>
    </div><p>

    <!-- <?= $form->field($model, 'profit_id') ?> -->

    <!-- <?= $form->field($model, 'transaksi_id') ?> -->

    <!-- <?= $form->field($model, 'profit') ?> -->

    <!-- <?= $form->field($model, 'sharing') ?> -->

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>
