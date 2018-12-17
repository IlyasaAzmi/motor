<?php

namespace backend\controllers;

use Yii;
use common\models\Transaksi;
use common\models\Motor;
use common\models\Paket;
use common\models\Profit;
use common\models\Kwitansi;
use backend\models\TransaksiSearch;
use backend\models\DendaSearch;
use backend\models\RekapSearch;
use backend\models\IncomeForm;
use backend\models\DateForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

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
                        'actions' => ['update', 'create', 'index', 'delete', 'view', 'paidoff', 'grids', 'list' , 'confirm', 'unconfirm', 'earn', 'take', 'untake', 'return', 'unreturn', 'confirmed', 'unconfirmed', 'paidoffed', 'earned', 'untaked', 'ongoing', 'income', 'ktm', 'ktp', 'perpus', 'nothing', 'date' ,'indeks', 'inconfirm'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
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

        $confirmed = Transaksi::find()
            ->where(['status' => Transaksi::STATUS_CONFIRM])
            ->count();

        $unconfirmed = Transaksi::find()
            ->where(['status' => Transaksi::STATUS_UNCONFIRM])
            ->count();

        $paidoff = Transaksi::find()
            ->where(['payment_status' => Transaksi::STATUS_PAIDOFF])
            ->count();

        $earn = Transaksi::find()
            ->where(['payment_status' => Transaksi::STATUS_EARN])
            ->count();

        $untaked = Transaksi::find()
            ->where(['payment_status' => Transaksi::STATUS_PAIDOFF])
            ->andWhere(['pengambilan_status'=>Transaksi::STATUS_UNTAKE])
            ->count();

        $ongoing = Transaksi::find()
            ->where(['pengambilan_status' => Transaksi::STATUS_TAKED])
            ->andWhere(['pengembalian_status'=>Transaksi::STATUS_UNRETURN])
            ->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'confirmed' => $confirmed,
            'unconfirmed' => $unconfirmed,
            'paidoff' => $paidoff,
            'earn' => $earn,
            'untaked' => $untaked,
            'ongoing' => $ongoing
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

        // $motor = Motor::find()->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
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

        $motor = Motor::find()->where(['status' => 1])->all();
        $motor = ArrayHelper::map($motor, 'motor_id','motor_name');

        $paket = Paket::find()->all();
        $paket = ArrayHelper::map($paket, 'paket_id','title');

        $n = rand(0,10000);
        $model->transaksi_id = 'RH'.$n;

        $model->paket_id = '2';

        // if (Yii::$app->request->isAjax && $model->load($_POST))
        // {
        //     Yii::$app->response->format = 'json';
        //     return yii\widgets\ActiveForm::validate($model);
        // }

        if ($model->load(Yii::$app->request->post())) {

            $model->customer_id =  Yii::$app->user->identity->id;

            $durasi = $model->duration;
            $start = strtotime($model->start_date);
            $return = date('Y-m-d H:i:s', strtotime('+'.($durasi).'day', $start));
            $model->transaksi_return_date = $return;

            $bayar = $durasi*30000;
            $model->payment = $bayar;
            $model->save();

            return $this->redirect(['view', 'id' => $model->transaksi_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'motor' => $motor,
            'paket' => $paket,
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
        $motor = Motor::find()->where(['status' => 1])->all();
        $motor = ArrayHelper::map($motor, 'motor_id','motor_name');

        $paket = Paket::find()->all();
        $paket = ArrayHelper::map($paket, 'paket_id','title');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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

        return $this->redirect(['index']);
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

    public function actionGrid()
    {
        $query = Transaksi::find();

        if (isset($_GET['Transaksi']))
        {
            $query->andFilterWhere([
                'customer_id' => isset($_GET['Transaksi']['customer_id'])?$_GET['Transaksi']['customer_id']:null,
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('grid', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionGrids()
    {
        $query = Transaksi::find();

        $confirmed = Transaksi::find()
            ->where(['status' => Transaksi::STATUS_CONFIRM])
            ->count();

        $unconfirmed = Transaksi::find()
            ->where(['status' => Transaksi::STATUS_UNCONFIRM])
            ->count();

        $paidoff = Transaksi::find()
            ->where(['payment_status' => Transaksi::STATUS_PAIDOFF])
            ->count();

        $earn = Transaksi::find()
            ->where(['payment_status' => Transaksi::STATUS_EARN])
            ->count();

        $untaked = Transaksi::find()
            ->where(['payment_status' => Transaksi::STATUS_PAIDOFF])
            ->andWhere(['pengambilan_status'=>Transaksi::STATUS_UNTAKE])
            ->count();

        $ongoing = Transaksi::find()
            ->where(['pengambilan_status' => Transaksi::STATUS_TAKED])
            ->andWhere(['pengembalian_status'=>Transaksi::STATUS_UNRETURN])
            ->count();

        $searchModel = new Transaksi();
        // $searchModel = new \backend\models\TransaksiSearch();

        if (isset($_GET['Transaksi']))
        {
            $searchModel->load( \Yii::$app->request->get());

            // $query->joinWith([['user']]);
            // $query->joinWith([['motor']]);

            // $query->andFilterWhere(
                // ['LIKE', 'user.username', $searchModel->getAttribute('user.username')],
                // ['LIKE', 'motor.title',$searchModel->getAttribute('motor.title')]
            // );

            $query->andFilterWhere([
                'transaksi_id' => $searchModel->transaksi_id,
                'customer_id' => $searchModel->customer_id,
                'motor_id' => $searchModel->motor_id,
                'paket' => $searchModel->paket_id,
                'transaksi_created_at' => $searchModel->transaksi_created_at,
                'transaksi_updated_at' => $searchModel->transaksi_updated_at,
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
            'confirmed' => $confirmed,
            'unconfirmed' => $unconfirmed,
            'paidoff' => $paidoff,
            'earn' => $earn,
            'untaked' => $untaked,
            'ongoing' => $ongoing
        ]);
    }

    public function actionMultipleGrid()
    {
        $transaksiQuery = Transaksi::find();
        $transaksiSearchModel = new TransaksiSearch();

        if (isset($_GET['TransaksiSearch']))
        {
            $transaksiSearchModel->load(\Yii::$app->request->get());

            $transaksiQuery->joinWith(['user']);
            $transaksiQuery->andFilterWhere(
                ['LIKE', 'user.username',
                $transaksiSearchModel->getAttribute('user.username')]
            );

            $transaksiQuery->andFilterWhere([
                'transaksi_id' => $transaksiSearchModel->transaksi_id,
                'customer_id' => $transaksiSearchModel->customer_id,
                'motor_id' => $transaksiSearchModel->motor_id,
                'duration' => $transaksiSearchModel->duration,
            ]);
        }

        $transaksiDataProvider = new ActiveDataProvider([
            'query' => $transaksiQuery,
            'sort' => [
                'sortParam' => 'transaksi-sort-param',
            ],
            'pagination' => [
                'pageSize' => 10,
                'pageParam' => 'transaksi-page-param'
            ],
        ]);

        $motorQuery = Motor::find();
        $motorSearchModel = new Motor;

        if (isset($_GET['Motor']))
        {
            $motorSearchModel->load(Yii::$app->request->get() );

            $motorQuery->andFilterWhere([
                'motor_id' => $motorSearchModel->motor_id,
                'plat' => $motorSearchModel->plat,
                'motor_name' => $motorSearchModel->motor_name,
                'start_date' => $motorSearchModel->start_date,
                'expired_date' => $motorSearchModel->expired_date,

            ]);
        }

        $motorDataProvider = new ActiveDataProvider([
            'query' => $motorQuery,
            'sort' => [
                'sortParam' => 'motors-sort-param',
            ],
            'pagination' => [
                'pageSize' => 10,
                'pageParam' => 'motor-page-param'
            ],
        ]);

        return $this->render('multipleGrid', [
            'transaksiDataProvider' => $transaksiDataProvider,
            'transaksiSearchModel' => $transaksiSearchModel,
            'motorDataProvider' => $motorDataProvider,
            'motorSearchModel' => $motorSearchModel,
        ]);
    }

    public function actionList()
    {
        $transaksis = Transaksi::find()->orderBy('transaksi_updated_at desc')->all();
        $count = Transaksi::find()
            ->where(['status' => Transaksi::STATUS_CONFIRM])
            ->count();

        return $this->render('list', [
            'transaksis' => $transaksis,
            'count' => $count
        ]);
    }

    public function actionConfirm($id)
    {

        if($transaksi->confirm())
        {
            $profit = new Profit;
            $profit->profit_id = 'P_'.$id;
            $profit->transaksi_id = $id;
            $profit->motor_id = $transaksi->motor_id;
            $profit->contributor_id = $transaksi->motor->contributor_id;
            $total = $transaksi->payment;

            if ($transaksi->motor->entrust_type == 70):
                $laba = (30/100) * $total;
                $bagi = $total - $laba;
                $profit->profit = $laba;
                $profit->sharing = $bagi;
                $profit->save();

            elseif ($transaksi->motor->entrust_type == 50):
                $laba = (50/100) * $total;
                $bagi = $total - $laba;
                $profit->profit = $laba;
                $profit->sharing = $bagi;
                $profit->save();

            elseif ($transaksi->motor->entrust_type == 100):
                $laba = (100/100) * $total;
                $bagi = $total - $laba;
                $profit->profit = $laba;
                $profit->sharing = $bagi;
                $profit->save();

            endif;

            return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
        }
    }

    public function actionUnconfirm($id, $idprf)
    {
       $transaksi = Transaksi::findOne($id);
       if($transaksi->unconfirm())
         {
            $profit = Profit::findOne($idprf);
            $profit->delete();

            return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
         }
    }

    public function actionInconfirm($id)
    {
       $transaksi = Transaksi::findOne($id);
       if($transaksi->unconfirm())
         {
            return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
         }
    }

    public function actionPaidoff($id)
    {
        $transaksi = Transaksi::findOne($id);
        if($transaksi->paidoff())
        {
            $kwitansi = new Kwitansi();
            $kwitansi->kwitansi_id = 'KW_'.$id;
            $kwitansi->transaksi_id = $id;
            $kwitansi->fee = $transaksi->payment;
            $kwitansi->note = 'Pembayaran Sewa (kode reservasi '.$transaksi->transaksi_id.' )';
            $kwitansi->save();

            return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
        }
    }

    public function actionEarn($id, $idkw)
    {
        $transaksi = Transaksi::findOne($id);
        if($transaksi->earn())
        {
            $kwitansi = Kwitansi::findOne($idkw);
            $kwitansi->delete();

            return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
        }
    }

    public function actionTake($id, $idmtr)
    {
        $transaksi = Transaksi::findOne($id);
        if($transaksi->take())
        {
            $motor = Motor::findOne($idmtr);
            $motor->current_status = 30;
            $motor->save();

            return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
        }
    }

     public function actionUntake($id, $idmtr)
     {
         $transaksi = Transaksi::findOne($id);
         if($transaksi->untake())
         {
             $motor = Motor::findOne($idmtr);
             $motor->current_status = 20;
             $motor->save();

             return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
         }
     }

     public function actionReturn($id, $idmtr)
      {
          $transaksi = Transaksi::findOne($id);
          if($transaksi->return())
          {
              $motor = Motor::findOne($idmtr);
              $motor->current_status = 10;
              $motor->save();
              return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
          }
      }

      public function actionUnreturn($id, $idmtr)
      {
          $transaksi = Transaksi::findOne($id);
          if($transaksi->unreturn())
          {
              $motor = Motor::findOne($idmtr);
              $motor->current_status = 30;
              $motor->save();

              return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
          }
      }

      public function actionChart(){
      	  $transaksi = Transaksi::find()->all();
          $response = [];
      	  foreach($transaksi as $data){
      		    $response[] = [
                  'transaksiId' => $data->transaksi_id,
                  'payment' => $data->payment,
              ];
      	  }
          return json_encode($response);
      }

      public function actionGrafik()
      {
          return $this->render('grafik');
      }

      public function actionConfirmed()
      {
          $searchModel = new TransaksiSearch();

          $query = Transaksi::find()
              ->where(['status' => Transaksi::STATUS_CONFIRM])
              ->orderBy('transaksi_updated_at desc');

          $dataProvider = new \yii\data\ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]);

          return $this->render('confirmed', [
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
          ]);
      }

      public function actionUnconfirmed()
      {
          $searchModel = new TransaksiSearch();

          $query = Transaksi::find()
              ->where(['status' => Transaksi::STATUS_UNCONFIRM])
              ->orderBy('transaksi_updated_at desc');

          $dataProvider = new \yii\data\ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]);

          return $this->render('unconfirmed', [
              'dataProvider' => $dataProvider,
              'searchModel' => $searchModel,
          ]);
      }

      public function actionPaidoffed()
      {
          $query = Transaksi::find()
              ->where(['payment_status' => Transaksi::STATUS_PAIDOFF])
              ->orderBy('transaksi_updated_at desc');

          $dataProvider = new \yii\data\ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]);

          return $this->render('paidoffed', [
              'dataProvider' => $dataProvider,
              // 'searchModel' => $searchModel,
          ]);
      }

      public function actionEarned()
      {
          $query = Transaksi::find()
              ->where(['payment_status' => Transaksi::STATUS_EARN])
              ->orderBy('transaksi_updated_at desc');

          $dataProvider = new \yii\data\ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]);

          return $this->render('earned', [
              'dataProvider' => $dataProvider,
              // 'searchModel' => $searchModel,
          ]);
      }

      public function actionUntaked()
      {
          $query = Transaksi::find()
              ->where(['payment_status' => Transaksi::STATUS_PAIDOFF])
              ->andWhere(['pengambilan_status'=>Transaksi::STATUS_UNTAKE]);

          $dataProvider = new \yii\data\ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]);

          return $this->render('earned', [
              'dataProvider' => $dataProvider,
              // 'searchModel' => $searchModel,
          ]);
      }

      public function actionOngoing()
      {
          $query = Transaksi::find()
              ->where(['pengambilan_status' => Transaksi::STATUS_TAKED])
              ->andWhere(['pengembalian_status'=>Transaksi::STATUS_UNRETURN]);

          $dataProvider = new \yii\data\ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 10,
              ],
          ]);

          return $this->render('ongoing', [
              'dataProvider' => $dataProvider,
              // 'searchModel' => $searchModel,
          ]);
      }

      public function actionIncome()
      {
          // // $searchModel = new TransaksiSearch();
          //
          // $query = Transaksi::find()
          //     ->where(['payment_status' => Transaksi::STATUS_PAIDOFF]);
          //
          // $dataProvider = new \yii\data\ActiveDataProvider([
          //     'query' => $query,
          //     'pagination' => [
          //         'pageSize' => 10,
          //     ],
          // ]);
          //
          // return $this->render('income', [
          //     'dataProvider' => $dataProvider,
          //     // 'searchModel' => $searchModel,
          // ]);

          $searchModel = new TransaksiSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
          $dataProvider->query->where(['payment_status'=> Transaksi::STATUS_PAIDOFF]);

          $searchModel2 = new DendaSearch();
          $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);

          // $jumlah = Transaksi::find()
          //     ->where(['payment_status' => Transaksi::STATUS_PAIDOFF])
          //     ->count();

          // if ($model->load(Yii::$app->request->post()) && $model->validate()){
          //     return $this->redirect(['transaksi/index', 'TransaksiSearch[transaksi_created_at]'=> $model->tahun.'-'.$model->bulan]);
          // }else{
              return $this->render('income', [
                  // 'model' => $model,
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
                  'searchModel2' => $searchModel2,
                  'dataProvider2' => $dataProvider2,
                  // 'jumlah' => $jumlah
              ]);
          // }

          // return $this->render('income', [
          //     'searchModel' => $searchModel,
          //     'dataProvider' => $dataProvider,
          //     'jumlah' => $jumlah
          // ]);
      }

    public function actionKtm($id)
    {
         $transaksi = Transaksi::findOne($id);
         if($transaksi->ktm())
         {
             return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
         }
    }

    public function actionKtp($id)
    {
         $transaksi = Transaksi::findOne($id);
         if($transaksi->ktp())
         {
             return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
         }
    }

    public function actionPerpus($id)
    {
         $transaksi = Transaksi::findOne($id);
         if($transaksi->perpus())
         {
             return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
         }
    }

    public function actionNothing($id)
    {
         $transaksi = Transaksi::findOne($id);
         if($transaksi->nothing())
         {
             return $this->redirect(['view','id'=> $transaksi->transaksi_id]);
         }
    }

    public function actionDate()
    {
        $model = new DateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            // return $this->redirect(['transaksi/indeks', 'TransaksiSearch[transaksi_updated_at]'=> $model->tahun.'-'.$model->bulan]);
            return $this->redirect(['transaksi/indeks', 'RekapSearch[transaksi_updated_at]' => $model->tahun.'-'.$model->bulan, 'DendaSearch[created_at]' => $model->tahun.'-'.$model->bulan]);
            // return $this->redirect(['transaksi/indeks', 'TransaksiSearch[transaksi_updated_at]' => $model->tahun.'-'.$model->bulan, '[payment_status]' => Transaksi::STATUS_PAIDOFF , 'DendaSearch[created_at]' => $model->tahun.'-'.$model->bulan]);
        }else{
            return $this->render('date', [
                'model' => $model,
            ]);
        }
    }

    public function actionIndeks()
    {
        $searchModel = new RekapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->query->where(['payment_status'=> Transaksi::STATUS_PAIDOFF]);
        $searchModel2 = new DendaSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        return $this->render('indeks', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionTanggal()
    {
        $model = new DateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            // return $this->redirect(['transaksi/indeks', 'TransaksiSearch[transaksi_updated_at]' => $model->tahun.'-'.$model->bulan]);
            return $this->redirect(['transaksi/laporan', 'DendaSearch[created_at]' => $model->tahun.'-'.$model->bulan]);
        }else{
            return $this->render('date', [
                'model' => $model,
            ]);
        }
    }

    public function actionLaporan()
    {
        $searchModel = new DendaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('laporan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
