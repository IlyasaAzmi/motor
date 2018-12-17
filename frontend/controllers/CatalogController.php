<?php

namespace frontend\controllers;

use Yii;
use common\models\Motor;
use common\models\Kategori;
use frontend\models\CatalogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;


/**
 * MotorController implements the CRUD actions for Motor model.
 */
class CatalogController extends Controller
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
     * Lists all Motor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $motor = Motor::find()
            // ->where(['status' => Motor::STATUS_ACTIVE])
            ->orderBy('motor_id ASC')
            ->all();

        $categories = Kategori::find()
            ->orderBy('title ASC')
            ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'motor' => $motor,
            'categories' => $categories
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
        $motor = Motor::find()->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
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
        $query = Motor::find()->where(['status' => 1]);
        $motors = $query->all();
        // $sql = 'SELECT * FROM motor ORDER BY motor_id ASC';
        // $motors = Yii::$app->db->createCommand($sql)->queryAll();

        return $this->render('list', ['motors' => $motors]);
    }

    public function actionDaftar()
    {
        $sql = 'SELECT * FROM motor ORDER BY motor_id ASC';
        $motors = Yii::$app->db->createCommand($sql)->queryAll();

        $categories = Kategori::find()
            ->orderBy('title ASC')
            ->all();

        return $this->render('daftar', [
            'motors' => $motors,
            'categories' => $categories,
        ]);
    }

    public function actionMatic()
    {
        $sql = 'SELECT * FROM motor WHERE kategori_id=1 ORDER BY motor_id ASC';
        $motors = Yii::$app->db->createCommand($sql)->queryAll();

        return $this->render('matic', [
            'motors' => $motors]
        );
    }

    public function actionBebek()
    {
        $sql = 'SELECT * FROM motor WHERE kategori_id=2 ORDER BY motor_id ASC';
        $motors = Yii::$app->db->createCommand($sql)->queryAll();

        return $this->render('bebek', [
            'motors' => $motors
        ]);
    }

    /**
    * @param Category[] $categories
    * @param int $activeId
    * @param int $parent
    * @return array
    */
    private function getMenuItems($kategori, $kategori_id)
    {
        $menuItems = [];
        foreach ($categories as $category) {
            if ($category->parent_id === $parent) {
                $menuItems[$category->id] = [
                    'active' => $activeId === $category->id,
                    'label' => $category->title,
                    'url' => ['catalog/list', 'id' => $category->id],
                    'items' => $this->getMenuItems($categories, $activeId, $category->id),
                ];
            }
        }
        return $menuItems;
    }

    public function actionMotorCategory($id)
    {
        $motors = Motor::find()
            ->where(['kategori_id' => $id])
            ->orderBy('motor_id DESC')
            ->all();

        $categories = Kategori::find()
            ->orderBy('title ASC')
            ->all();

        return $this->render('motorCategory', [
            'motors' => $motors,
            'categories' => $categories,
        ]);
    }

    public function actionMotorSingle($id)
    {
        $motors = Motor::find()
            ->where(['motor_id' => $id])
            ->one();

        $categories = Kategori::find()
            ->orderBy('title ASC')
            ->all();
        return $this->render('motorSingle', [
            'motors' => $motors,
            'categories' => $categories,
        ]);
    }

    public function actionListbycat($id)
    {
        $motor = new Motor();
        $motor = $motor->getMotorByCat($id);

        $categories = Kategori::find()
            ->orderBy('title ASC')
            ->all();

        return $this->render('listMotor',[
            'motor' => $motor,
            'categories' => $categories
        ]);
    }

}
