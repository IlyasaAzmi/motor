<?php

use yii\grid\Gridview;
use yii\helpers\Html;
use common\models\Motor;
use yii\widgets\ActiveForm;

$this->title = 'Pemasukan';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin();?>
    <h2><strong>Rekap Pemasukan Sewa Motor:</strong></h2>
    <?= $form->field($model, 'bulan',['options' => ['class' => 'col-md-6']])->dropDownList([
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
        '12' => 'Desemeber',
    ], ['prompt' => 'Pilh Bulan'])?>
    <?= $form->field($model, 'tahun',['options' => ['class' => 'col-md-6']])->dropDownList([
        '2018' => '2018',
        '2019' => '2019',
        '2020' => '2020'
    ], ['prompt' => 'Pilh Tahun'])?>

    <div class="form-group">
        <?= Html::submitButton('Telusuri', ['class' => 'btn btn-primary'])?>
    </div>
<?php ActiveForm::end();?>
