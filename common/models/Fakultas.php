<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fakultas".
 *
 * @property int $fakultas_id
 * @property string $title
 *
 * @property Prodi[] $prodis
 * @property Profile[] $profiles
 */
class Fakultas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fakultas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fakultas_id', 'title'], 'required'],
            [['fakultas_id'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['fakultas_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fakultas_id' => 'Fakultas ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdis()
    {
        return $this->hasMany(Prodi::className(), ['fakultas_id' => 'fakultas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['fakultas_id' => 'fakultas_id']);
    }
}
