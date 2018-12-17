<?php

namespace backend\controllers;

use Yii;
use common\models\Blog;
use backend\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
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
            //     'only' => ['update', 'create', 'index', 'delete','grids'],
            //     'rules' => [
            //         [
            //             'allow' => 'true',
            //             'roles' => ['admin']
            //         ]
            //     ]
            // ]
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
      			        'class' => AccessRule::className(),
      			    ],
                'rules' => [
                    [
                        'actions' => ['update', 'create', 'index', 'delete','grids', 'remove', 'allow', 'disallow', 'view'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */

    //ACTION DELETE POST
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
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
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog();
        // $blog = new Blog();
        $oldImage = null;

        if ($model->load(Yii::$app->request->post()))
        {


            // $blog->on(Blog::EVENT_OUR_CUSTOM_EVENT, function($event) {
            // $followers = ['john2@teleworm.us', 'shivawhite@cuvox.de', 'kate@dayrep.com' ];
            // foreach($followers as $follower)
            // {
            //     Yii::$app->mailer->compose()
            //         ->setFrom('techblog@teleworm.us')
            //         ->setTo($follower)
            //         ->setSubject($event->sender->title)
            //         ->setTextBody($event->sender->text)
            //         ->send();
            // }
            // echo 'Emails have been sent';
            // });
            //
            // if ($blog->save()) {
            // $blog->trigger(Blog::EVENT_OUR_CUSTOM_EVENT);
            // }

            $blogId = $model->blog_id;
            $image = UploadedFile::getInstance($model, 'gambar');
            if(isset($image)){
                $imgName = '_'.$blogId.'.'.$image->getExtension();
                $image->saveAs(Yii::getAlias('@blogImgPath').$imgName);
                $model->gambar = $imgName;
            }
            else {
                $model->gambar = $oldImage;
            }

            if($model->save()){
                Yii::$app->mailer->compose('register',[
                    'model'=>$model
                    ])
                    ->setFrom('test@test.com')
                    ->setTo('theazmi99liyasa@gmail.com')
                    ->setSubject('Welcome U3 Motor')
                    ->send();
                    
                if(isset($image)){
                    $image->saveAs(Yii::getAlias('@blogImgPath').$imgName);
                }
            }

            Yii::$app->session->setFlash('success','Data blog berhasil disimpan');

            return $this->redirect(['view', 'id' => $model->blog_id]);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //
        //     $blogId = $model->blog_id;
        //     $image = UploadedFile::getInstance($model, 'gambar');
        //     $imgName = '_'.$blogId.'.'.$image->getExtension();
        //     $image->saveAs(Yii::getAlias('@blogImgPath').$imgName); //here we need to give path to where to upload this function works same as move_uploaded_file in php
        //
        //     $model->gambar = $imgName;
        //     $model->save();
        //
        //     Yii::$app->session->setFlash('success','Data blog berhasil disimpan');
        //
        //     return $this->redirect(['view', 'id' => $model->blog_id]);
        // }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Blog model.
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
            $blogId = $model->blog_id;
            $image = UploadedFile::getInstance($model, 'gambar');
            if(isset($image)){
                $imgName = '_'.$blogId.'.'.$image->getExtension();
                $image->saveAs(Yii::getAlias('@blogImgPath').$imgName);
                $model->gambar = $imgName;
            }
            else {
                $model->gambar = $oldImage;
            }

            if($model->save()){
                if(isset($image)){
                    $image->saveAs(Yii::getAlias('@blogImgPath').$imgName);
                }
            }

            Yii::$app->session->setFlash('success','Data blog berhasil diperbarui');

            return $this->redirect(['view', 'id' => $model->blog_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blog model.
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
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGrids()
    {
       $blogs = Blog:: find()->orderBy('updated_at desc')->all();

       return $this->render('grids',[
            'blogs' => $blogs
       ]);
    }

    public function actionRemove($id)
    {
        $blog = Blog::findOne($id);
        if($blog->delete())
        {
            return $this->redirect(['blog/grids']);
        }
    }

    public function actionAllow($id)
    {
        $blog = Blog::findOne($id);
        if($blog->allow())
        {
            return $this->redirect(['view', 'id' => $blog->blog_id]);
        }
    }

    public function actionDisallow($id)
    {
        $blog = Blog::findOne($id);
        if($blog->disallow())
        {
            return $this->redirect(['view', 'id' => $blog->blog_id]);
        }
    }
}
