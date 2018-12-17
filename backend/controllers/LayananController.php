<?php

namespace backend\controllers;

use Yii;
use common\models\Layanan;
use backend\models\LayananSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LayananController implements the CRUD actions for Layanan model.
 */
class LayananController extends Controller
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
        ];
    }

    /**
     * Lists all Layanan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LayananSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Layanan model.
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
     * Creates a new Layanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Layanan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

          if (!empty($model->gambar)){
              $model->save();
              $layananId = $model->layanan_id;
              $image = UploadedFile::getInstance($model, 'gambar');
              $imgName = '_'.$layananId.'.'.$image->getExtension();
              $image->saveAs(Yii::getAlias('@layananImgPath').$imgName); //here we need to give path to where to upload this function works same as move_uploaded_file in php

              $model->gambar = $imgName;
          }

          $model->save();
          Yii::$app->session->setFlash('success','Data layanan berhasil disimpan');

            return $this->redirect(['view', 'id' => $model->layanan_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Layanan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImage = $model->gambar;

        if ($model->load(Yii::$app->request->post()))
        {
            $image = UploadedFile::getInstance($model, 'gambar');
            $layananId = $model->layanan_id;
            if(isset($image)){
                $imgName = '_'.$layananId.'.'.$image->getExtension();
                $image->saveAs(Yii::getAlias('@layananImgPath').$imgName);
                $model->gambar = $imgName;
            }
            else {
                $model->gambar = $oldImage;
            }

            if($model->save()){
                if(isset($image)){
                    $image->saveAs(Yii::getAlias('@layananImgPath').$imgName);
                }
            }

            Yii::$app->session->setFlash('success','Data layanan berhasil diperbarui');

            return $this->redirect(['view', 'id' => $model->layanan_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Layanan model.
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
     * Finds the Layanan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Layanan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Layanan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
