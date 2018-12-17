<?php

namespace backend\controllers;

use Yii;
use common\models\Contributor;
use backend\models\ContributorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;

/**
 * ContributorController implements the CRUD actions for Contributor model.
 */
class ContributorController extends Controller
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
                'class' => AccessControl::className(),
                'ruleConfig' => [
      			        'class' => AccessRule::className(),
      			    ],
                'rules' => [
                    [
                        'actions' => ['update', 'create', 'index', 'delete', 'view', 'list', 'active', 'inactive', 'actived', 'inactived'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Contributor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContributorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contributor model.
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
     * Creates a new Contributor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contributor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->contributor_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contributor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->contributor_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Contributor model.
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
     * Finds the Contributor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contributor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contributor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionList()
    {
        $contributors = Contributor:: find()->orderBy('contributor_id asc')->all();

        return $this->render('list', [
            'contributors' => $contributors,
        ]);
    }

    public function actionActive($id)
    {
        $contributor = Contributor::findOne($id);
        if($contributor->active())
        {
            return $this->redirect(['view','id'=> $contributor->contributor_id]);
        }
    }

    public function actionInactive($id)
    {
        $contributor = Contributor::findOne($id);
        if($motor->inactive())
        {
            return $this->redirect(['view','id'=> $contributor->contributor_id]);
        }
    }

    public function actionActived()
    {
        $query = Contributor::find()
            ->where(['status' => Contributor::STATUS_ACTIVE]);
            // ->orderBy('updated_at desc');

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
        $query = Contributor::find()
            ->where(['status' => Contributor::STATUS_ACTIVE]);
            // ->orderBy('updated_at desc');

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

}
