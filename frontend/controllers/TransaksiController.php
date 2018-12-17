<?php

namespace frontend\controllers;

use Yii;
use common\models\Transaksi;
use common\models\Paket;
use common\models\Motor;
use common\models\User;
use common\models\Invoice;
use frontend\models\HourForm;
use frontend\models\TransaksiSearch;
use frontend\models\AvailableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\IdentityInterface;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * TransaksiController implements the CRUD actions for Transaksi model.
 */
class TransaksiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::classname(),
                'only' => ['update', 'create', 'index', 'delete', 'jam', 'minggu', 'bulan'],
                'rules' => [
                    [
                        'allow' => 'true',
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Transaksi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransaksiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaksi model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $motor = Motor::find()->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'motor' => $motor
        ]);
    }

    public function actionDetail($id)
    {
        $motor = Motor::find()->all();

        return $this->render('detail', [
            'model' => $this->findModel($id),
            'motor' => $motor
        ]);
    }

    /**
     * Creates a new Transaksi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaksi();

        $sql = 'SELECT * FROM motor ORDER BY motor_id ASC';
        $motors = Yii::$app->db->createCommand($sql)->queryAll();

        $motor = Motor::find()->where(['status' => 1])->all();
        $motor = ArrayHelper::map($motor, 'motor_id', 'motor_name');

        $paket = Paket::find()->all();
        $paket = ArrayHelper::map($paket, 'paket_id', 'title');

        $n = rand(0,10000);
        $model->transaksi_id = "RH".$n;

        $model->paket_id = '2';
        // $model->motor_id = 'MTR001';
        $model->jaminan_status == Transaksi::STATUS_NOTHING;

        $customer = User::findOne(Yii::$app->user->identity->id);
        $transaksis = $customer->getTransaksis()
            ->where(['status' => Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_id')
            ->count();

        $aktif = Transaksi::find()
            ->where(['customer_id'=> Yii::$app->user->identity->id])
            ->andWhere(['status'=> Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_updated_at DESC');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $aktif,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'transaksi_updated_at' => SORT_DESC,
                ]
            ],
        ]);

        if (Yii::$app->request->isAjax && $model->load($_POST))
        {
            Yii::$app->response->format = 'json';
            return yii\widgets\ActiveForm::validate($model);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->customer_id = Yii::$app->user->identity->id;

            $durasi = $model->duration;
            $start = strtotime($model->transaksi_start_date);
            $return =  date('Y-m-d H:i:s', strtotime('+'.($durasi).' day', $start));
            $model->transaksi_return_date = $return;

            $bayar = $durasi*30000;
            $model->payment = $bayar;
            $model->save();

            Yii::$app->session->setFlash('success', "Silahkan pilih salah satu motor yang tersedia");

            return $this->redirect(['motor', 'id' => $model->transaksi_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'motor' => $motor,
            'paket' => $paket,
            'motors' => $motors,
            'transaksis' => $transaksis,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionJam()
    {
        $model = new Transaksi();

        $sql = 'SELECT * FROM motor ORDER BY motor_id ASC';
        $motors = Yii::$app->db->createCommand($sql)->queryAll();

        $motor = Motor::find()->all();
        $motor = ArrayHelper::map($motor, 'motor_id', 'motor_name');

        $paket = Paket::find()->all();
        $paket = ArrayHelper::map($paket, 'paket_id', 'title');

        $n = rand(0,10000);
        $model->transaksi_id = "RJ".$n;

        $model->paket_id = '1';
        // $model->motor_id = 'MTR001';
        $model->jaminan_status == Transaksi::STATUS_NOTHING;

        $customer = User::findOne(Yii::$app->user->identity->id);
        $transaksis = $customer->getTransaksis()
            ->where(['status' => Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_id')
            ->count();

        $aktif = Transaksi::find()
            ->where(['customer_id'=> Yii::$app->user->identity->id])
            ->andWhere(['status'=> Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_updated_at DESC');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $aktif,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'transaksi_updated_at' => SORT_DESC,
                ]
            ],
        ]);

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->customer_id = Yii::$app->user->identity->id;

            $durasi = $model->duration;
            $start = strtotime($model->transaksi_start_date);
            $return =  date('Y-m-d H:i:s', strtotime('+'.($durasi).' hour', $start));
            $model->transaksi_return_date = $return;

            $bayar = $durasi*3000;
            $model->payment = $bayar;
            $model->save();

            Yii::$app->session->setFlash('success', "Silahkan pilih salah satu motor yang tersedia");

            return $this->redirect(['motor', 'id' => $model->transaksi_id]);
        }

        return $this->render('jam', [
            'model' => $model,
            'motor' => $motor,
            'paket' => $paket,
            'motors' => $motors,
            'transaksis' => $transaksis,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionMinggu()
    {
        $model = new Transaksi();

        $sql = 'SELECT * FROM motor ORDER BY motor_id ASC';
        $motors = Yii::$app->db->createCommand($sql)->queryAll();

        $motor = Motor::find()->all();
        $motor = ArrayHelper::map($motor, 'motor_id', 'motor_name');

        $paket = Paket::find()->all();
        $paket = ArrayHelper::map($paket, 'paket_id', 'title');

        $n = rand(0,10000);
        $model->transaksi_id = "RM".$n;

        $model->paket_id = '3';
        // $model->motor_id = 'MTR001';
        $model->jaminan_status == Transaksi::STATUS_NOTHING;

        $customer = User::findOne(Yii::$app->user->identity->id);
        $transaksis = $customer->getTransaksis()
            ->where(['status' => Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_id')
            ->count();

        $aktif = Transaksi::find()
            ->where(['customer_id'=> Yii::$app->user->identity->id])
            ->andWhere(['status'=> Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_updated_at DESC');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $aktif,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'transaksi_updated_at' => SORT_DESC,
                ]
            ],
        ]);

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->customer_id = Yii::$app->user->identity->id;

            $durasi = $model->duration;
            $start = strtotime($model->transaksi_start_date);
            $return =  date('Y-m-d H:i:s', strtotime('+'.($durasi).' week', $start));
            $model->transaksi_return_date = $return;

            $bayar = $durasi*150000;
            $model->payment = $bayar;
            $model->save();

            Yii::$app->session->setFlash('success', "Silahkan pilih salah satu motor yang tersedia");

            return $this->redirect(['motor', 'id' => $model->transaksi_id]);
        }

        return $this->render('minggu', [
            'model' => $model,
            'motor' => $motor,
            'motors' => $motors,
            'paket' => $paket,
            'transaksis' => $transaksis,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionBulan()
    {
        $model = new Transaksi();

        $sql = 'SELECT * FROM motor ORDER BY motor_id ASC';
        $motors = Yii::$app->db->createCommand($sql)->queryAll();

        $motor = Motor::find()->all();
        $motor = ArrayHelper::map($motor, 'motor_id', 'motor_name');

        $paket = Paket::find()->all();
        $paket = ArrayHelper::map($paket, 'paket_id', 'title');

        $n = rand(0,10000);
        $model->transaksi_id = "RB".$n;

        $model->paket_id = '4';
        // $model->motor_id = 'MTR001';
        $model->jaminan_status == Transaksi::STATUS_NOTHING;

        $customer = User::findOne(Yii::$app->user->identity->id);
        $transaksis = $customer->getTransaksis()
            ->where(['status' => Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_id')
            ->count();

        $aktif = Transaksi::find()
            ->where(['customer_id'=> Yii::$app->user->identity->id])
            ->andWhere(['status'=> Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_updated_at DESC');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $aktif,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'transaksi_updated_at' => SORT_DESC,
                ]
            ],
        ]);

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->customer_id = Yii::$app->user->identity->id;

            $durasi = $model->duration;
            $start = strtotime($model->transaksi_start_date);
            $return =  date('Y-m-d H:i:s', strtotime('+'.($durasi).' month', $start));
            $model->transaksi_return_date = $return;

            $bayar = $durasi*500000;
            $model->payment = $bayar;
            $model->save();

            Yii::$app->session->setFlash('success', "Silahkan pilih salah satu motor yang tersedia");

            return $this->redirect(['motor', 'id' => $model->transaksi_id]);
        }

        return $this->render('bulan', [
            'model' => $model,
            'motor' => $motor,
            'paket' => $paket,
            'motors' => $motors,
            'transaksis' => $transaksis,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Updates an existing Transaksi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $motor = Motor::find()->all();
        $motor = ArrayHelper::map($motor, 'motor_id', 'motor_name');

        $paket = Paket::find()->all();
        $paket = ArrayHelper::map($paket, 'paket_id', 'title');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->customer_id = Yii::$app->user->identity->id;

            $durasi = $model->duration;
            $start = strtotime($model->transaksi_start_date);
            $return =  date('Y-m-d H:i:s', strtotime('+'.($durasi).' day', $start));
            $model->transaksi_return_date = $return;
            $model->save();

            $bayar = $durasi*30000;
            $model->payment = $bayar;
            $model->save();

            return $this->redirect(['view', 'id' => $model->transaksi_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'motor' => $motor,
            'paket' => $paket,
        ]);
    }

    /**
     * Deletes an existing Transaksi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $idmtr)
    {
        $motor = Motor::findOne($idmtr);
        $motor->current_status = 10;
        $motor->save();

        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', "Transaksi telah dibatalkan oleh customer");

        return $this->redirect(['/site/index']);
    }

    public function actionClear($id)
    {

        $this->findModel($id)->delete();

        return $this->redirect(['reservasi']);
    }

    public function actionCancel($id)
    {

        $this->findModel($id)->delete();

        return $this->redirect(['/site/index']);
    }

    /**
     * Finds the Transaksi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Transaksi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaksi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPaket()
    {
        $sql = 'SELECT * FROM paket ORDER BY paket_id ASC';
        $pakets = Yii::$app->db->createCommand($sql)->queryAll();

        return $this->render('paket', ['pakets' => $pakets]);
    }

    public function actionDate()
    {
        $model = new Transaksi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['date', 'id' => $model->transaksi_id]);
        }

        return $this->render('date', [
            'model' => $model,
        ]);
    }

    public function actionMotorTest()
    {
        $sql = 'SELECT * FROM motor ORDER BY motor_id ASC';
        $motors = Yii::$app->db->createCommand($sql)->queryAll();

        // return $this->render('motor', ['motors' => $motors]);

        $model = new Transaksi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['date', 'id' => $model->transaksi_id]);
        }

        return $this->render('motor-test', [
            'motors' => $motors,
            'model' => $model,
        ]);
    }

    public function actionOrder()
    {
        $model = new Transaksi();

        $motor = Motor::find()->all();
        $motor = ArrayHelper::map($motor, 'motor_id', 'motor_name');

        $paket = Paket::find()->all();
        $paket = ArrayHelper::map($paket, 'paket_id', 'title');

        $customer = User::find()->all();
        $customer = ArrayHelper::map($customer, 'id', 'username');

        return $this->render('order', [
            'model' => $model,
            'motor' => $motor,
            'paket' => $paket,
            'customer' => $customer
        ]);
    }

    public function actionMotor($id)
    {
        $searchModel = new AvailableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Transaksi();

        $sql = 'SELECT * FROM motor WHERE current_status=10 ORDER BY motor_id ASC';
        $motors = Yii::$app->db->createCommand($sql)->queryAll();

        $motor = Motor::find()
            ->where(['status' => Motor::STATUS_ACTIVE])
            ->andWhere(['current_status' => Motor::CURRENT_STATUS_AVAILABLE])
            ->orderBy('year DESC')
            ->all();

        $paket = Paket::find()->all();

        return $this->render('motor', [
            'model' => $this->findModel($id),
            'motor' => $motor,
            'paket' => $paket,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMtr($id, $idmtr)
    {
        $motor = Motor::findOne($idmtr);
        $motor->current_status = 20;
        $motor->save();

        $model = $this->findModel($id);
        $model->motor_id = $idmtr;
        $model->save();

        $invoice = new Invoice();
        $invoice->invoice_id = 'INV_'.$id;
        $invoice->transaksi_id = $id;
        $invoice->bill = $model->payment;
        $invoice->save();

        if (!$model->motor_id == null) {

            Yii::$app->session->setFlash('success', "Terima kasih. Reservasi telah dilakukan. Silahkan membayar ke U3 Motor.");

            return $this->render('view', [
                'model' => $model,
                'motor' => $motor
            ]);
        } else {
            Yii::$app->session->setFlash('error', "Reservasi belum komplet.");

            return $this->render('motor', [
                'model' => $model,
                'motor' => $motor
            ]);
        }

        // return $this->render('view', [
        //     'model' => $model,
        //     'motor' => $motor
        // ]);

    }

    public function actionfilterMotor()
    {
        $query = Motor::find()
            ->where(['status' => Motor::STATUS_ACTIVE]);

        $available = Transaksi::find()
            ->where(['status' => TRANSAKSI::STATUS_CONFIRM]);

        return $this->render('filterMotor', [
            'query' => $query,
            'available' => $available,
        ]);
    }

    public function actionPdf()
    {
        $content = $this->renderPartial('pdf');

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'options' => ['title' => 'Laporan Apa Aja']
        ]);

        return $pdf->render();
    }

    public function actionGenPdf($id)
    {
        $model = new Transaksi();
        $pdfFile = $model->transaksi_id;

        $pdf_content = $this->renderPartial('view-pdf', [
            'model' => $this->findModel($id),
        ]);

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHTMLHeader('
        <div style="text-align: center; font-weight: bold;">
            U3 Motor
        </div>');
        $mpdf->SetHTMLFooter('
        <table width="100%">
            <tr>
                <td width="33%">{DATE j-m-Y}</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;">www.u3motor.com</td>
            </tr>
        </table>
        ');
        $mpdf->WriteHTML($pdf_content);
        $mpdf->Output('bukti.pdf', 'D');
        exit;
    }

    public function actionLihat($id)
    {
        $model = Transaksi::findOne($id);

        return $this->render('lihat',[
            'model' => $model
        ]);
    }

    public function actionHistory()
    {
        // $model = Transaksi::find()->all();

        $searchModel = new TransaksiSearch();
        $query = Transaksi::find()
            ->where(['customer_id'=>Yii::$app->user->identity->id])
            ->orderBy('transaksi_updated_at DESC');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'transaksi_updated_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'model' => $model,
        ]);
    }

    public function actionReservasi()
    {
        return $this->render('reservasi');
    }

    public function actionHour()
    {
        $model = new HourForm();
        $transaksi = new Transaksi();
        $motor = Motor::find()
            ->where(['status' => Motor::STATUS_ACTIVE])
            ->andWhere(['current_status' => Motor::CURRENT_STATUS_AVAILABLE])
            ->orderBy('year DESC')
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // valid data received in $model

            // do something meaningful here about $model ...

            return $this->render('pilih',
                [
                    'model' => $model,
                    'transaksi' => $transaksi,
                    'motor' => $motor
                ]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('hour', ['model' => $model]);
        }
    }

    public function actionPilih()
    {
        // $model = new Transaksi();
        $motor = Motor::find()
            ->where(['status' => Motor::STATUS_ACTIVE])
            ->andWhere(['current_status' => Motor::CURRENT_STATUS_AVAILABLE])
            ->orderBy('year DESC')
            ->all();
    }

    public function actionPlh($idmtr)
    {
        $form = new HourForm();

        $transaksi = new Transaksi();

        $mtr = Motor::findOne($idmtr);
        // $mtr->current_status = 20;
        // $mtr->save();

        $n = rand(0,10000);
        $transaksi->transaksi_id = "RH".$n;
        $transaksi->motor_id = $idmtr;
        $transaksi->paket_id = '1';
        $transaksi->jaminan_status == Transaksi::STATUS_NOTHING;
        $transaksi->customer_id = Yii::$app->user->identity->id;

        $transaksi->transaksi_start_date = $form->start;
        $transaksi->duration = $form->duration;
        $durasi = $form->duration;
        $start = strtotime($transaksi->transaksi_start_date);
        $return =  date('Y-m-d H:i:s', strtotime('+'.($durasi).' day', $start));
        $transaksi->transaksi_return_date = $return;

        $bayar = $durasi*30000;
        $transaksi->payment = $bayar;
        $transaksi->save();

        $motor = Motor::find()
            ->where(['status' => Motor::STATUS_ACTIVE])
            ->andWhere(['current_status' => Motor::CURRENT_STATUS_AVAILABLE])
            ->orderBy('year DESC')
            ->all();

        if (!$transaksi->transaksi_id == null) {

            Yii::$app->session->setFlash('success', "Terima kasih. Reservasi telah dilakukan. Silahkan membayar ke U3 Motor.");

            return $this->render('invoice', [
                'model' => $this->findModel($id),
                'motor' => $motor
            ]);
        }

        // return $this->render('pilih',
        //     [
        //         'model' => $model,
        //         'transaksi' => $transaksi,
        //         'motor' => $motor
        //     ]);

    }

    public function actionInvoice($id)
    {
        $motor = Motor::find()->all();

        return $this->render('invoice', [
            'model' => $this->findModel($id),
            'motor' => $motor
        ]);
    }

    public function actionRent()
    {
        $query = User::find()
            ->where(['id'=>Yii::$app->user->identity->id])
            ->one();

        $customer = User::findOne(Yii::$app->user->identity->id);

        $searchModel = new TransaksiSearch();
        $aktif = Transaksi::find()
            ->where(['customer_id'=> Yii::$app->user->identity->id])
            ->andWhere(['status'=> Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_updated_at DESC');

        $transaksis = $customer->getTransaksis()
            ->where(['status' => Transaksi::STATUS_UNCONFIRM])
            ->orderBy('transaksi_id')
            ->count();

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $aktif,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'transaksi_updated_at' => SORT_DESC,
                ]
            ],
        ]);

        // $dataProvider = new \yii\data\ActiveDataProvider([
        //     'query' => $query,
        // ]);

        return $this->render('rent', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'query' => $query,
            'aktif' => $aktif,
            'transaksis' => $transaksis
        ]);
    }
}
