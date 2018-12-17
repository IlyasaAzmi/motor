<?php

namespace common\models;

use dektrium\user\models\Profile;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use dektrium\user\models\User;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     * Add a new field
     * @var string
     */
    public $name;
    public $nim;
    public $prodi;
    public $asrama;
    public $phone;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        $user = $this->module->modelMap['User'];

        $rules = parent::rules();
        $rules[] = ['name', 'required'];
        $rules[] = ['name', 'string', 'max' => 255];
        $rules['nimRequired'] = ['nim', 'required'];
        $rules['nimUnique'] = [
            'nim',
            'unique',
            'targetClass' => $user,
            'message' => \Yii::t('user', 'NIM sudah terdaftar')
        ];
        $rules['nimLength']   = ['nim', 'number'];
        $rules['prodiRequired'] = ['prodi', 'required'];
        $rules['prodiLength']   = ['prodi', 'string', 'max' => 30];
        $rules['asramaRequired'] = ['asrama', 'required'];
        $rules['asramaLength']   = ['asrama', 'string', 'max' => 30];
        $rules['phoneRequired'] = ['phone', 'required'];
        $rules['phoneLength']   = ['phone', 'number'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['nim'] = \Yii::t('user', 'NIM');
        $labels['name'] = \Yii::t('user', 'Nama Lengkap');
        $labels['prodi'] = \Yii::t('user', 'Program Studi');
        $labels['asrama'] = \Yii::t('user', 'Asrama');
        $labels['phone'] = \Yii::t('user', 'No. Handphone');
        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function loadAttributes(User $user)
    {
        // here is the magic happens
        $user->setAttributes([
            'email'    => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'nim' => $this->nim,
            'prodi' => $this->prodi,
            'asrama' => $this->asrama,
            'phone' => $this->phone,
        ]);
        /** @var Profile $profile */
        $profile = \Yii::createObject(Profile::className());
        $profile->setAttributes([
            'name' => $this->name,
        ]);
        $user->setProfile($profile);
    }

    public function listProdi()
    {
        return [
            'TI' => 'Teknik Informatika',
            'Agro' => 'Agroteknologi',
            'TIP' => 'Teknologi Industri Pertanian',
            'AFI' => 'Aqidah dan Filsafat Islam',
            'IQT' => 'llmu Al-Quran dan Tafsir',
            'SAA' => 'Studi Agama-Agama',
            'HES' => 'Hukum Ekonomi Syariah',
            'PM' => 'Perbandingan Madzhab',
            'EI' => 'Ekonomi Islam',
            'MB' => 'Manajemen Bisnis',
            'PAI' => 'Pendidikan Agama Islam',
            'PBA' => 'Pendidikan Bahasa Arab',
            'HI' => 'Hubungan Internasional',
            'ILKOM' => 'Ilmu Komunikasi',
            'K3' => 'Keselamatan dan Kesehatan Kerja',
            'FRM' => 'Farmasi',
            'GIZI' => 'Ilmu Gizi',
        ];
    }
}
