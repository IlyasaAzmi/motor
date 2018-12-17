<?php

namespace backend\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class DashboardController extends \yii\web\Controller
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

    public function actionIndex()
    {
        return $this->render('index');
    }

}
