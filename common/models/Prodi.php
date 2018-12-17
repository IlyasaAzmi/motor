<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prodi".
 *
 * @property int $prodi_id
 * @property string $title
 * @property int $fakultas_id
 *
 * @property Fakultas $fakultas
 * @property Profile[] $profiles
 */
class Prodi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prodi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prodi_id', 'title', 'fakultas_id'], 'required', 'message' => '{attribute} harus diisi'],
            [['prodi_id', 'fakultas_id'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['prodi_id'], 'unique'],
            [['fakultas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fakultas::className(), 'targetAttribute' => ['fakultas_id' => 'fakultas_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'prodi_id' => 'Prodi ID',
            'title' => 'Title',
            'fakultas_id' => 'Fakultas',
            'fakultas.title' => 'Fakultas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFakultas()
    {
        return $this->hasOne(Fakultas::className(), ['fakultas_id' => 'fakultas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['prodi_id' => 'prodi_id']);
    }
}
