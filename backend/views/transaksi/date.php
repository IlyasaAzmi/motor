<?php

use yii\grid\Gridview;
use yii\helpers\Html;
use common\models\Motor;
use yii\widgets\ActiveForm;

$this->title = 'Form Rekap Transaksi Bulanan';
?>

<h1><?= Html::encode($this->title) ?></h1>

<br />

<?php $form = ActiveForm::begin([
    'options' => [
        'enctype'=>'multipart/form-data',
        'class' => 'form-horizontal',
        ],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-2 control-label'],
    ],

]);?>

    <?= $form->field($model, 'bulan')->dropDownList([
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ], ['prompt' => 'Pilih Bulan'])?>

    <?= $form->field($model, 'tahun')->dropDownList([
        '2018' => '2018',
        '2019' => '2019',
        '2020' => '2020'
    ], ['prompt' => 'Pilh Tahun'])?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton('Cari', ['class' => 'btn btn-primary'])?>
        </div>
    </div>

<?php ActiveForm::end();?>
