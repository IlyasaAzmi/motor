<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "denda".
 *
 * @property int $denda_id
 * @property string $transaksi_id
 * @property int $tipe
 * @property int $charge
 * @property string $note
 * @property string $created_at
 */
class Denda extends \yii\db\ActiveRecord
{
    const TIPE_TERLAMBAT = 10;
    const TIPE_RUSAK = 20;
    const TIPE_TERLAMBAT_DAN_RUSAK = 30;

    const DENDA_HUTANG = 0;
    const DENDA_LUNAS = 1;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    // ActiveRecord::EVENT_BEFORE_UPDATE => ['transaksi_updated_at'],
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
        return 'denda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaksi_id', 'tipe', 'charge', 'note'], 'required'],
            [['tipe', 'charge'], 'integer'],
            [['note'], 'string'],
            [['created_at'], 'safe'],
            [['transaksi_id'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'denda_id' => 'Denda ID',
            'transaksi_id' => 'Transaksi ID',
            'tipe' => 'Tipe',
            'charge' => 'Charge',
            'note' => 'Note',
            'created_at' => 'Created At',
        ];
    }

    public function getTransaksi()
    {
        return $this->hasOne(Transaksi::className(), ['transaksi_id' => 'transaksi_id']);
    }

    public function getMotor()
    {
        return $this
           ->hasOne(Motor::className(), ['motor_id' => 'denda_id'])
           ->viaTable('transaksi', ['transaksi_id' => 'motor_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'staf_id']);
    }

    public function getKwitansi()
    {
        return $this->hasMany(Kwitansi::className(), ['transaksi_id' => 'denda_id']);
    }

    public function getReceipt()
    {
        return $this->hasOne(Receipt::className(), ['denda_id' => 'denda_id']);
    }

    public function tipeDenda()
    {
        return [
            10 => 'Keterlambatan',
            20 => 'Kerusakan',
            30 => 'Keterlambatan dan Kerusakan',
        ];
    }

    public function isPayed()
    {
        return $this->bayar_status;
    }

    public function lunas()
    {
        $this->bayar_status = self::DENDA_LUNAS;
        return $this->save(false);
    }

    public function hutang()
    {
        $this->bayar_status = self::DENDA_HUTANG;
        return $this->save(false);
    }
}
