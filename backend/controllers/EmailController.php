<?php

namespace backend\controllers;

use Yii;
use common\models\Email;
use backend\models\EmailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * EmailController implements the CRUD actions for Email model.
 */
class EmailController extends Controller
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
     * Lists all Email models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Email model.
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
     * Creates a new Email model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Email();

        if ($model->load(Yii::$app->request->post())) {

            //upload the attachment
            $model->attachment = UploadedFile::getInstance($model, 'attachment');

            if ($model->attachment)
            {
                $time = time();
                $model->attachment->saveAs('attachments/' .$time.'.'. $model->attachment->extension);
                $model->attachment = 'attachments/' .$time.'.'. $model->attachment->extension;
            }

            if ($model->attachment) {
                $value = Yii::$app->mailer->compose()
                ->setFrom([ 'ilyasa.azmi@unida.gontor.ac.id' => 'U3 Motor'])
                ->setTo($model->receiver_email)
                ->setSubject($model->subject)
                ->setHtmlBody($model->content)
                ->attach($model->attachment)
                ->send();
            }else {
                $value =  Yii::$app->mailer->compose()
                ->setFrom([ 'ilyasa.azmi@unida.gontor.ac.id' => 'ilyasa'])
                ->setTo($model->receiver_email)
                ->setSubject($model->subject)
                ->setHtmlBody($model->content)
                ->send();
            }
            $model->save();

            // print_r($model->getErrors());
            // die();
            return $this->redirect(['view', 'id' => $model->email_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Email model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->email_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Email model.
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
     * Finds the Email model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Email the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Email::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTestEmail()
    {
        Yii::$app->mailer->compose()
            ->setTo('theazmi99ilyasa@gmail.com')
            ->setFrom('ilyasa.azmi@unida.gontor.ac.id')
            ->setSubject('test')
            ->setTextBody('this is test body')
            ->send();
    }
}
