<?php

namespace backend\controllers;

use Yii;
use common\models\Paket;
use backend\models\PaketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * PaketController implements the CRUD actions for Paket model.
 */
class PaketController extends Controller
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
                'only' => ['update', 'create', 'index', 'delete'],
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
     * Lists all Paket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Paket model.
     * @param integer $id
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
     * Creates a new Paket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Paket();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->save();
            $paketId = $model->paket_id;
            $image = UploadedFile::getInstance($model, 'gambar');
            $imgName = '_'.$paketId.'.'.$image->getExtension();
            $image->saveAs(Yii::getAlias('@paketImgPath').$imgName); //here we need to give path to where to upload this function works same as move_uploaded_file in php

            $model->gambar = $imgName;
            $model->save();
            Yii::$app->session->setFlash('success','Data paket berhasil disimpan');

            return $this->redirect(['view', 'id' => $model->paket_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Paket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->save();
            $paketId = $model->paket_id;
            $image = UploadedFile::getInstance($model, 'gambar');
            $imgName = '_'.$paketId.'.'.$image->getExtension();
            $image->saveAs(Yii::getAlias('@paketImgPath').$imgName); //here we need to give path to where to upload this function works same as move_uploaded_file in php

            $model->gambar = $imgName;
            $model->save();
            Yii::$app->session->setFlash('success','Data paket berhasil diperbarui');

            return $this->redirect(['view', 'id' => $model->paket_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Paket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Paket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
