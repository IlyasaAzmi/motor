<?php

namespace backend\controllers;

use Yii;
use common\models\Motor;
use common\models\Kategori;
use backend\models\MotorSearch;
use backend\models\DateForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\data\ActiveDataProvider;
use mPDF;



/**
 * MotorController implements the CRUD actions for Motor model.
 */
class MotorController extends Controller
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
            // 'access' => [
            //     'class' => AccessControl::classname(),
            //     'only' => ['update', 'create', 'index', 'delete'],
            //     'rules' => [
            //         [
            //             'allow' => 'true',
            //             'roles' => ['@']
            //         ]
            //     ]
            // ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
      			        'class' => AccessRule::className(),
      			    ],
                'rules' => [
                    [
                        'actions' => ['update', 'create', 'index', 'delete', 'view', 'list', 'report', 'grids', 'active', 'inactive', 'actived', 'inactived', 'date', 'available', 'booked', 'onrent', 'added', 'availabled', 'book', 'onrented'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Motor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MotorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $kategori = Kategori::find()->all();
        $kategori = ArrayHelper::map($kategori, 'kategori_id', 'title');

        $inactived = Motor::find()
            ->where(['status' => Motor::STATUS_INACTIVE])
            ->count();

        $actived = Motor::find()
            ->where(['status' => Motor::STATUS_ACTIVE])
            ->count();

        $availabled = Motor::find()
            ->where(['current_status' => '10'])
            ->count();

        $booked = Motor::find()
            ->where(['current_status' => '20'])
            ->count();

        $onrented = Motor::find()
            ->where(['current_status' => '30'])
            ->count();

        $added = Motor::find()
            ->where(['current_status' => '0'])
            ->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kategori' => $kategori,
            'actived' => $actived,
            'inactived' => $inactived,
            'availabled' => $availabled,
            'booked' => $booked,
            'onrented' => $onrented,
            'added' => $added,
        ]);
    }

    /**
     * Displays a single Motor model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Motor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Motor();

        $kategori = Kategori::find()->all();
        $kategori = ArrayHelper::map($kategori, 'kategori_id', 'title');

        if ($model->load(Yii::$app->request->post())&& $model->save()) {

            // $model->save();
            $motorId = $model->motor_id;
            $image = UploadedFile::getInstance($model, 'gambar');
            $imgName = '_'.$motorId.'.'.$image->getExtension();
            $image->saveAs(Yii::getAlias('@motorImgPath').$imgName); //here we need to give path to where to upload this function works same as move_uploaded_file in php

            $model->gambar = $imgName;
            $model->save();
            Yii::$app->session->setFlash('success','Data motor berhasil disimpan');

            return $this->redirect(['view', 'id' => $model->motor_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'kategori' => $kategori
        ]);
    }

    /**
     * Updates an existing Motor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $kategori = Kategori::find()->all();
        $kategori = ArrayHelper::map($kategori, 'kategori_id', 'title');

        $model = $this->findModel($id);

        $oldImage = $model->gambar;
        $motorId = $model->motor_id;
        $image = UploadedFile::getInstance($model, 'gambar');

        if ($model->load(Yii::$app->request->post()))
        {
            if(isset($image)){
                $imgName = '_'.$motorId.'.'.$image->getExtension();
                $image->saveAs(Yii::getAlias('@motorImgPath').$imgName);
                $model->gambar = $imgName;
            }
            else {
                $model->gambar = $oldImage;
            }

            if($model->save()){
                if(isset($image)){
                    $image->saveAs(Yii::getAlias('@motorImgPath').$imgName);
                }
            }

            return $this->redirect(['view', 'id' => $model->motor_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'kategori' => $kategori
        ]);
    }

    /**
     * Deletes an existing Motor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Motor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Motor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Motor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionList()
    {
        // $sql = 'SELECT * FROM motor ORDER BY motor_id ASC';
        // $motors = Yii::$app->db->createCommand($sql)->queryAll();
        $motors = Motor::find()->orderBy('motor_id asc')->all();

        return $this->render('list', [
            'motors' => $motors
        ]);
    }

    // public function actionDeleteGambar($id)
    // {
    //     $model = Motor::findOne($id);
    //     if ($model->deleteGambar()){
    //         Yii::$app->session->setFlash('success',
    //         'Your image was removed successfully. Upload another by clicking browse below');
    //     } else {
    //         Yii::$app->session->setFlash('error',
    //         'Error removing image. Please try again later or contact the system administrator');
    //     }
    //
    // }

    public function actionReport() {

        //get your Html raw content without any layout or scripts

        // $content = "
        //     <b style='color:red'>bold</b>
        //     <img src='".Url::to('@web/img/UNIDA8.jpg'. true)."' />
        //     <a href='http://u3motor.com'>u3motor.com</a>"
        //     ;

        $content = $this->renderPartial('_pdf-dealer',[
            'model' => $model,

        ]);

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

        return $pdf->render();
     }

     public function actionGenPdf($id)
     {
          $pdf_content = $this->renderPartial('view-pdf', [
              'model' => $this->findModel($id),
          ]);

          $mpdf = new \Mpdf\Mpdf();
          $mpdf->WriteHTML($pdf_content);
          $mpdf->Output();
          exit;
     }

     public function actionGrids()
     {
         $query = Motor::find();

         $inactived = Motor::find()
             ->where(['status' => Motor::STATUS_INACTIVE])
             ->count();

         $actived = Motor::find()
             ->where(['status' => Motor::STATUS_ACTIVE])
             ->count();

         $searchModel = new Motor();
         // $searchModel = new \backend\models\TransaksiSearch();

         if (isset($_GET['Motor']))
         {
             $searchModel->load( \Yii::$app->request->get());

             // $query->joinWith([['user']]);
             // $query->joinWith([['motor']]);

             // $query->andFilterWhere(
                 // ['LIKE', 'user.username', $searchModel->getAttribute('user.username')],
                 // ['LIKE', 'motor.title',$searchModel->getAttribute('motor.title')]
             // );

             $query->andFilterWhere([
                 'motor_id' => $searchModel->motor_id,
                 'plat' => $searchModel->plat,
                 'motor_name' => $searchModel->motor_name,
                 'kategori_id' => $searchModel->kategori_id,
                 'contributor_id' => $searchModel->contributor_id,
                 'status' => $searchModel->status,
             ]);
         }

         $dataProvider = new ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => 10,
             ],
         ]);

         return $this->render('grids', [
             'dataProvider' => $dataProvider,
             'searchModel' => $searchModel,
             'actived' => $actived,
             'inactived' => $inactived
         ]);
     }

     public function actionActive($id)
     {
         $motor = Motor::findOne($id);
         if($motor->active())
         {
             return $this->redirect(['view','id'=> $motor->motor_id]);
         }
     }

     public function actionInactive($id)
     {
         $motor = Motor::findOne($id);
         if($motor->inactive())
         {
             return $this->redirect(['view','id'=> $motor->motor_id]);
         }
     }

     public function actionActived()
     {
         $query = Motor::find()
             ->where(['status' => Motor::STATUS_ACTIVE])
             ->orderBy('updated_at desc');

         $dataProvider = new \yii\data\ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => 10,
             ],
         ]);

         return $this->render('actived', [
             'dataProvider' => $dataProvider,
             // 'searchModel' => $searchModel,
         ]);
     }

     public function actionInactived()
     {
         $query = Motor::find()
             ->where(['status' => Motor::STATUS_INACTIVE])
             ->orderBy('updated_at desc');

         $dataProvider = new \yii\data\ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => 10,
             ],
         ]);

         return $this->render('inactived', [
             'dataProvider' => $dataProvider,
             // 'searchModel' => $searchModel,
         ]);
     }

     public function actionDate()
     {
         $model = new DateForm();

         if ($model->load(Yii::$app->request->post()) && $model->validate()){
             return $this->redirect(['motor/index', 'MotorSearch[start_date]'=> $model->tahun.'-'.$model->bulan]);
         }else{
             return $this->render('date', [
                 'model' => $model,
             ]);
         }
     }

     public function actionAvailable($id)
     {
          $motor = Motor::findOne($id);
          if($motor->available())
          {
              return $this->redirect(['view','id'=> $motor->motor_id]);
          }
     }

     public function actionBooked($id)
     {
          $motor = Motor::findOne($id);
          if($motor->booked())
          {
              return $this->redirect(['view','id'=> $motor->motor_id]);
          }
     }

     public function actionOnrent($id)
     {
          $motor = Motor::findOne($id);
          if($motor->onrent())
          {
              return $this->redirect(['view','id'=> $motor->motor_id]);
          }
     }

     public function actionAdded()
     {
         $query = Motor::find()
             ->where(['current_status' => Motor::CURRENT_STATUS_PENDING])
             ->orderBy('updated_at desc');

         $dataProvider = new \yii\data\ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => 20,
             ],
         ]);

         return $this->render('added', [
             'dataProvider' => $dataProvider,
             // 'searchModel' => $searchModel,
         ]);
     }

     public function actionAvailabled()
     {
         $query = Motor::find()
             ->where(['current_status' => Motor::CURRENT_STATUS_AVAILABLE])
             ->orderBy('updated_at desc');

         $dataProvider = new \yii\data\ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => 20,
             ],
         ]);

         return $this->render('availabled', [
             'dataProvider' => $dataProvider,
             // 'searchModel' => $searchModel,
         ]);
     }

     public function actionBook()
     {
         $query = Motor::find()
             ->where(['current_status' => Motor::CURRENT_STATUS_BOOKED])
             ->orderBy('updated_at desc');

         $dataProvider = new \yii\data\ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => 20,
             ],
         ]);

         return $this->render('book', [
             'dataProvider' => $dataProvider,
             // 'searchModel' => $searchModel,
         ]);
     }

     public function actionOnrented()
     {
         $query = Motor::find()
             ->where(['current_status' => Motor::CURRENT_STATUS_ONRENT])
             ->orderBy('updated_at desc');

         $dataProvider = new \yii\data\ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => 20,
             ],
         ]);

         return $this->render('onrented', [
             'dataProvider' => $dataProvider,
             // 'searchModel' => $searchModel,
         ]);
     }
}
