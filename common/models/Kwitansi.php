<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "kwitansi".
 *
 * @property string $kwitansi_id
 * @property string $transaksi_id
 * @property int $fee
 * @property string $note
 * @property string $created_at
 */
class Kwitansi extends \yii\db\ActiveRecord
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
        return 'kwitansi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kwitansi_id', 'transaksi_id', 'fee', 'note'], 'required'],
            [['fee'], 'integer'],
            [['created_at', 'staf_id'], 'safe'],
            [['kwitansi_id', 'transaksi_id'], 'string', 'max' => 50],
            [['note'], 'string', 'max' => 100],
            [['kwitansi_id'], 'unique'],
            [['transaksi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transaksi::className(), 'targetAttribute' => ['transaksi_id' => 'transaksi_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kwitansi_id' => 'Kwitansi ID',
            'transaksi_id' => 'Transaksi ID',
            'fee' => 'Biaya',
            'note' => 'Note',
            'created_at' => 'Waktu Pembayaran',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksi()
    {
        return $this->hasOne(Transaksi::className(), ['transaksi_id' => 'transaksi_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'staf_id']);
    }

    public function getDenda()
    {
        return $this->hasOne(Denda::className(), ['denda_id' => 'transaksi_id']);
    }
}
