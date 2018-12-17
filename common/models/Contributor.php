<?php

namespace common\models;

use Yii;
use common\models\Motor;

/**
 * This is the model class for table "contributor".
 *
 * @property int $contributor_id
 * @property string $name
 * @property string $phone
 * @property string $email
 *
 * @property Motor[] $motors
 */
class Contributor extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contributor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['contributor_id'], 'unique'],
            ['email','email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contributor_id' => 'Contributor ID',
            'name' => 'Name',
            'phone' => 'Nomor Handphone',
            'email' => 'Alamat Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotors()
    {
        return $this->hasMany(Motor::className(), ['contributor_id' => 'contributor_id']);
    }

    public function getMotorsCount()
    {
        return $this->hasMany(Motor::classname(), ['contributor_id' => 'contributor_id']) -> count();
    }
    public function isActived()
    {
        return $this->status;
    }

    public function active()
    {
        $this->status = self::STATUS_ACTIVE;
        return $this->save(false);
    }

    public function inactive()
    {
        $this->status = self::STATUS_INACTIVE;
        return $this->save(false);
    }
    
}
