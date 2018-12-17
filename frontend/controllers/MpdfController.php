<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use kartik\mpdf\Pdf;
use yii\helpers\Url;

class MpdfController extends Controller
{
    public function actionReport() {

        //get your Html raw content without any layout or scripts

        // $content = "
        //     <b style='color:red'>bold</b>
        //     <img src='".Url::to('@web/img/UNIDA8.jpg'. true)."' />
        //     <a href='http://u3motor.com'>u3motor.com</a>"
        //     ;

        $content = $this->renderPartial('index');

        //setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            //set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            //A4 paper format
            'format' => Pdf::FORMAT_A4,
            //portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browse inline
            'destination' =>  Pdf::DEST_BROWSER,
            //your HTML content input
            'content' => $content,
            //format content from your own css file if needed or use the enhanced bootstrap css built by krajee for pdf formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap',
            //call pdf method on the fly
            'methods' => [
                'SetHeader' => ['U3 MOTOR INVOICE'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        //http response
        $response = Yii::$app->response;
        // $response->format = \yii\web\Responsive::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/pdf');

        return $pdf->render('contoh');
     }

     public function actionIndex()
     {
        return $this->render('index');
     }
}
 ?>
