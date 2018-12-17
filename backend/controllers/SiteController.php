<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use common\models\LoginForm;
use common\models\Motor;
use common\models\Transaksi;
use common\models\Feedback;
use common\models\Denda;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
      			        'class' => AccessRule::className(),
      			    ],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        // 'roles' => ['@'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $inactived = Motor::find()
            ->where(['status' => Motor::STATUS_INACTIVE])
            ->count();

        $actived = Motor::find()
            ->where(['status' => Motor::STATUS_ACTIVE])
            ->count();

        $sepeda = Motor::find()
            ->count();

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

        $reservasi = Transaksi::find()
            ->count();

        $transaksis = Transaksi::find()
            ->orderBy('transaksi_updated_at desc')
            ->all();

        $motors = Motor::find()
            ->orderBy('updated_at desc')
            ->all();

        $feedbacks = Feedback::find()
            ->orderBy('updated_at desc')
            ->all();

        $dendas = Denda::find()
            ->orderBy('created_at desc')
            ->all();

        return $this->render('index',[
            'actived' => $actived,
            'inactived' => $inactived,
            'confirmed' => $confirmed,
            'unconfirmed' => $unconfirmed,
            'paidoff' => $paidoff,
            'earn' => $earn,
            'untaked' => $untaked,
            'ongoing' => $ongoing,
            'transaksis' => $transaksis,
            'motors' => $motors,
            'sepeda' => $sepeda,
            'reservasi' => $reservasi,
            'feedbacks' => $feedbacks,
            'dendas' => $dendas
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
