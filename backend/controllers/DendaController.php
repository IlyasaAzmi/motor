<?php

namespace backend\controllers;

use Yii;
use common\models\Denda;
use common\models\Kwitansi;
use common\models\Receipt;
use backend\models\DendaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;

/**
 * DendaController implements the CRUD actions for Denda model.
 */
class DendaController extends Controller
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
                        'actions' => ['update', 'create', 'index', 'delete', 'view', 'lunas', 'hutang', 'lunased', 'hutanged', 'terlambat', 'kerusakan', 'terusak'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Denda models.
     * @return mixed
     */
    public function actionIndex()
    {
        $terlambat = Denda::find()
            ->where(['tipe' => Denda::TIPE_TERLAMBAT])
            ->count();

        $rusak = Denda::find()
            ->where(['tipe' => Denda::TIPE_RUSAK])
            ->count();

        $terusak = Denda::find()
            ->where(['tipe' => Denda::TIPE_TERLAMBAT_DAN_RUSAK])
            ->count();

        $lunased = Denda::find()
            ->where(['bayar_status' => Denda::DENDA_LUNAS])
            ->count();

        $hutanged = Denda::find()
            ->where(['bayar_status' => Denda::DENDA_HUTANG])
            ->count();

        $searchModel = new DendaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'terlambat' => $terlambat,
            'rusak' => $rusak,
            'terusak' => $terusak,
            'lunased' => $lunased,
            'hutanged' => $hutanged,
        ]);
    }

    /**
     * Displays a single Denda model.
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
     * Creates a new Denda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Denda();
        $model->denda_id = 'D'.$id;
        $model->transaksi_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->denda_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Denda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->denda_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Denda model.
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
     * Finds the Denda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Denda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Denda::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLunas($id)
    {
        $denda = Denda::findOne($id);
        if($denda->lunas())
        {
            $receipt = new Receipt();
            $receipt->receipt_id = 'R_'.$id;
            $receipt->denda_id = $id;
            $receipt->fee = $denda->charge;
            $receipt->note = 'Pembayaran Denda (kode denda : '.$id.')';
            $receipt->save();

            return $this->redirect(['view','id'=> $denda->denda_id]);
        }
    }

    public function actionHutang($id, $idkw)
    {
        $denda = Denda::findOne($id);
        if($denda->hutang())
        {
            $receipt = Receipt::findOne($idkw);
            $receipt->delete();

            return $this->redirect(['view','id'=> $denda->denda_id]);
        }
    }

    public function actionLunased()
    {
        $query = Denda::find()
            ->where(['bayar_status' => Denda::DENDA_LUNAS])
            ->orderBy('created_at desc');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('lunased', [
            'dataProvider' => $dataProvider,
            // 'searchModel' => $searchModel,
        ]);
    }

    public function actionHutanged()
    {
        $query = Denda::find()
            ->where(['bayar_status' => Denda::DENDA_HUTANG])
            ->orderBy('created_at desc');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('hutanged', [
            'dataProvider' => $dataProvider,
            // 'searchModel' => $searchModel,
        ]);
    }

    public function actionTerlambat()
    {
        $query = Denda::find()
            ->where(['tipe' => Denda::TIPE_TERLAMBAT])
            ->orderBy('created_at desc');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('terlambat', [
            'dataProvider' => $dataProvider,
            // 'searchModel' => $searchModel,
        ]);
    }

    public function actionKerusakan()
    {
        $query = Denda::find()
            ->where(['tipe' => Denda::TIPE_RUSAK])
            ->orderBy('created_at desc');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('kerusakan', [
            'dataProvider' => $dataProvider,
            // 'searchModel' => $searchModel,
        ]);
    }

    public function actionTerusak()
    {
        $query = Denda::find()
            ->where(['tipe' => Denda::TIPE_TERLAMBAT_DAN_RUSAK])
            ->orderBy('created_at desc');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('terusak', [
            'dataProvider' => $dataProvider,
            // 'searchModel' => $searchModel,
        ]);
    }
}
