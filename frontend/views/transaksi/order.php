<?php
use yii\helpers\Html;


$this->title = 'Reservasi';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$wizard_config = [
  	'id' => 'stepwizard',
  	'steps' => [
  		1 => [
    			'title' => 'Tanggal',
    			'icon' => 'glyphicon glyphicon-calendar',
    			'content' =>  $this->render('_form', ['model' => $model,
                                                'motor' => $motor,
                                                'paket' => $paket,]),
    			'buttons' => [
      				'next' => [
        					'title' => 'Forward',
        					'options' => [
        						//'class' => 'disabled'
      				],
      				],
    			 ],
  		],

  		2 => [
    			'title' => 'Motor',
    			'icon' => 'fa fa-motorcycle',
    			'content' => $this->render('_form', ['model' => $model,
                                                'motor' => $motor,
                                                'paket' => $paket,]),
    			//'skippable' => true,
  		],

  		3 => [
    			'title' => 'Form Order',
    			'icon' => 'glyphicon glyphicon-send',
    			'content' => $this->render('_form', ['model' => $model,
                                                'motor' => $motor,
                                                'paket' => $paket,]),
  		],
    ],

    'complete_content' => "Reservasi Anda telah dilakukan. Silahkan melakukan pembayaran langsung di U3 Motor!", // Optional final screen
    //'start_step' => 1, // Optional, start with a specific step
];
?>

<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>
