<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property string $nim
 * @property int $customer_id
 * @property string $ktm
 * @property int $fakultas_id
 * @property int $prodi_id
 * @property string $phone
 *
 * @property Customer $customer
 * @property Fakultas $fakultas
 * @property Prodi $prodi
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'customer_id', 'ktm', 'fakultas_id', 'prodi_id', 'phone'], 'required'],
            [['customer_id', 'fakultas_id', 'prodi_id'], 'integer'],
            [['nim', 'phone'], 'string', 'max' => 50],
            [['ktm'], 'string', 'max' => 100],
            [['nim'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['fakultas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fakultas::className(), 'targetAttribute' => ['fakultas_id' => 'fakultas_id']],
            [['prodi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prodi::className(), 'targetAttribute' => ['prodi_id' => 'prodi_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nim' => 'NIM',
            'customer_id' => 'Customer ID',
            'ktm' => 'Ktm',
            'fakultas_id' => 'Fakultas ID',
            'prodi_id' => 'Prodi ID',
            'phone' => 'Phone',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
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
    public function getProdi()
    {
        return $this->hasOne(Prodi::className(), ['prodi_id' => 'prodi_id']);
    }
}
