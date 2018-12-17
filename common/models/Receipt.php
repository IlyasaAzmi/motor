<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "receipt".
 *
 * @property string $receipt_id
 * @property string $denda_id
 * @property int $fee
 * @property string $note
 * @property string $created_at
 * @property int $staf_id
 */
class Receipt extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['created_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'staf_id',
                'updatedByAttribute' => 'staf_id',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'receipt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['receipt_id', 'denda_id', 'fee', 'note'], 'required'],
            [['fee', 'staf_id'], 'integer'],
            [['created_at'], 'safe'],
            [['receipt_id', 'denda_id'], 'string', 'max' => 50],
            [['note'], 'string', 'max' => 100],
            [['receipt_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'receipt_id' => 'Receipt ID',
            'denda_id' => 'Denda ID',
            'fee' => 'Fee',
            'note' => 'Note',
            'created_at' => 'Created At',
            'staf_id' => 'Staf ID',
        ];
    }

    public function getDenda()
    {
        return $this->hasOne(Transaksi::className(), ['denda_id' => 'denda_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'staf_id']);
    }
}
