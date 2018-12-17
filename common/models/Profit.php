<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "profit".
 *
 * @property int $profit_id
 * @property string $transaksi_id
 * @property int $profit
 * @property int $sharing
 */
class Profit extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    // ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaksi_id', 'profit', 'sharing'], 'required'],
            [['profit', 'sharing'], 'integer'],
            [['transaksi_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profit_id' => 'Profit ID',
            'transaksi_id' => 'Transaksi ID',
            'profit' => 'Profit',
            'sharing' => 'Sharing',
        ];
    }

    public function getTransaksi()
    {
        return $this->hasOne(Transaksi::className(), ['transaksi_id' => 'transaksi_id']);
    }

    public function getMotor()
    {
        return $this->hasOne(Motor::className(), ['motor_id' => 'motor_id']);
    }

    public function getContributor()
    {
        return $this->hasOne(Contributor::className(), ['contributor_id' => 'contributor_id']);
    }
}
