<?php

namespace backend\controllers;

use Yii;
use yii\web\controller;
use common\models\User;
use yii\data\ActiveDataProvider;

class UserController extends controller
{
    public function actionIndex()
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGrid()
    {
        $query = User::find();

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
}
 ?>
