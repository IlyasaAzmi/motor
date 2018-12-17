<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaksi".
 *
 * @property string $transaksi_id
 * @property int $motor_id
 * @property int $customer_id
 * @property int $paket_id
 * @property string $start_date
 * @property string $return_date
 * @property string $created_at
 * @property string $note
 *
 * @property Feedback[] $feedbacks
 * @property Invoice[] $invoices
 * @property Customer $customer
 * @property Motor $motor
 * @property Paket $paket
 */
class Order extends yii\base\Model
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaksi_id', 'motor_id', 'customer_id', 'paket_id', 'start_date', 'return_date', 'created_at'], 'required', 'message' => '{attribute} harus diisi'],
            [['motor_id', 'customer_id', 'paket_id'], 'integer'],
            [['start_date', 'return_date', 'created_at'], 'safe'],
            [['note'], 'string'],
            [['transaksi_id'], 'string', 'max' => 50],
            [['transaksi_id'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['motor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Motor::className(), 'targetAttribute' => ['motor_id' => 'motor_id']],
            [['paket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paket::className(), 'targetAttribute' => ['paket_id' => 'paket_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transaksi_id' => 'Kode Transaksi',
            'motor_id' => 'Motor ID',
            'customer_id' => 'Customer ID',
            'paket_id' => 'Paket ID',
            'start_date' => 'Waktu Mulai',
            'return_date' => 'Waktu Pengembalian',
            'created_at' => 'Created At',
            'note' => 'Catatan Penyewa',
        ];
    }

    public function jamDurasi()
    {
        return [
            1 => '1 jam',
            2 => '2 jam',
            3 => '3 jam',
            4 => '4 jam',
            5 => '5 jam',
            6 => '6 jam',
            7 => '7 jam',
            8 => '8 jam',
            9 => '9 jam',
            10 => '10 jam',
        ];
    }

    public function hariDurasi()
    {
        return [
            1 => '1 hari',
            2 => '2 hari',
            3 => '3 hari',
            4 => '4 hari',
            5 => '5 hari',
            6 => '6 hari',
        ];
    }

    public function mingguDurasi()
    {
        return [
            1 => '1 minggu',
            2 => '2 minggu',
            3 => '3 minggu',
        ];
    }

    public function bulanDurasi()
    {
        return [
            1 => '1 bulan',
            2 => '2 bulan',
        ];
    }
}
