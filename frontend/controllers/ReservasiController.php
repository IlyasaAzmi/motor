<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\DateForm;
use common\models\Motor;

class ReservasiController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDateForm()
    {
        $model = new DateForm();

        $motor = Motor::find()
            ->where(['status' => 0])
            ->orderBy('motor_id ASC')
            ->all();

        $n = rand(0,10000);
        $model->kode = "RH".$n;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->customer = Yii::$app->user->identity->username;

            $durasi = $model->duration;
            $start = strtotime($model->start_date);
            $return =  date('Y-m-d H:i', strtotime('+'.($durasi).' day', $start));
            $model->return_date = $return;
            // $model->save();

            $bayar = $durasi*30000;
            $model->payment = $bayar;
            // $model->save();

            return $this->render('date-confirm', [
                'model' => $model,
                'motor' => $motor
            ]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('date-form', [
                'model' => $model
            ]);
        }
    }

    // public function actionDateConfirm()
    // {
    //     $model = new DateForm();
    //
    //     $motor = Motor::find()
    //         ->orderBy('motor_id ASC')
    //         ->all();
    //
    //     return $this->render('date-confirm', [
    //         'model' => $model,
    //         'motor' => $motor,
    //     ]);
    // }

}
