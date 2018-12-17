<?php
namespace common\models;

use dektrium\user\models\User as BaseUser;
use yii\helpers\ArrayHelper;

class User extends BaseUser
{
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to scenarios
        // $scenarios['create'][]   = ['nim', 'prodi', 'asrama'];
        // $scenarios['update'][]   = ['nim', 'prodi', 'asrama'];
        // $scenarios['register'][] = ['nim', 'prodi', 'asrama'];
        return ArrayHelper::merge($scenarios, [
            'register' => ['nim', 'prodi', 'asrama', 'phone'],
            // 'connect'  => ['username', 'email'],
            'create'   => ['nim', 'prodi', 'asrama', 'phone'],
            'update'   => ['nim', 'prodi', 'asrama', 'phone'],
            // 'settings' => ['username', 'email', 'password'],
        ]);

        return $scenarios;
    }

    public function rules()
    {
        $rules = parent::rules();

        // add some rules
        // $rules['nimLength']   = ['nim', 'string', 'max' => 10];

        return $rules;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['nim'] = \Yii::t('user', 'NIM');
        $labels['prodi'] = \Yii::t('user', 'Program Studi');
        $labels['asrama'] = \Yii::t('user', 'Asrama');
        $labels['phone'] = \Yii::t('user', 'No. Handphone');
        return $labels;
    }

    public function getTransaksis()
    {
        return $this->hasMany(Transaksi::className(), ['customer_id' => 'id']);
    }

    public function getTransaksisCount()
    {
        return $this->hasMany(Transaksi::classname(), ['customer_id' => 'id']) -> count();
    }
}
