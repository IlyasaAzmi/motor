<?php

namespace backend\controllers;

use Yii;
use common\models\Poster;
use backend\models\PosterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PosterController implements the CRUD actions for Poster model.
 */
class PosterController extends Controller
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
     * Lists all Poster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PosterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Poster model.
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
     * Creates a new Poster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Poster();
        $oldImage = null;

        if ($model->load(Yii::$app->request->post()))
        {
            $posterId = $model->poster_id;
            $image = UploadedFile::getInstance($model, 'gambar');
            if(isset($image)){
                $imgName = '_'.$posterId.'.'.$image->getExtension();
                $image->saveAs(Yii::getAlias('@posterImgPath').$imgName);
                $model->gambar = $imgName;
            }
            else {
                $model->gambar = $oldImage;
            }

            if($model->save()){
                if(isset($image)){
                    $image->saveAs(Yii::getAlias('@posterImgPath').$imgName);
                }
            }

            Yii::$app->session->setFlash('success','Data poster berhasil disimpan');

            return $this->redirect(['view', 'id' => $model->poster_id]);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //
        //     $posterId = $model->poster_id;
        //     $image = UploadedFile::getInstance($model, 'gambar');
        //     $imgName = '_'.$posterId.'.'.$image->getExtension();
        //     $image->saveAs(Yii::getAlias('@posterImgPath').$imgName); //here we need to give path to where to upload this function works same as move_uploaded_file in php
        //
        //     $model->gambar = $imgName;
        //     $model->save();
        //
        //     Yii::$app->session->setFlash('success','Data poster berhasil disimpan');
        //
        //     return $this->redirect(['view', 'id' => $model->poster_id]);
        // }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Poster model.
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
            $posterId = $model->poster_id;
            $image = UploadedFile::getInstance($model, 'gambar');
            if(isset($image)){
                $imgName = '_'.$posterId.'.'.$image->getExtension();
                $image->saveAs(Yii::getAlias('@posterImgPath').$imgName);
                $model->gambar = $imgName;
            }
            else {
                $model->gambar = $oldImage;
            }

            if($model->save()){
                if(isset($image)){
                    $image->saveAs(Yii::getAlias('@posterImgPath').$imgName);
                }
            }

            Yii::$app->session->setFlash('success','Data poster berhasil diperbarui');

            return $this->redirect(['view', 'id' => $model->poster_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Poster model.
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
     * Finds the Poster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Poster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Poster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
