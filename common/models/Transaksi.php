<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

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
 * @property string $updated_at
 *
 * @property Feedback[] $feedbacks
 * @property Invoice[] $invoices
 * @property Customer $customer
 * @property Motor $motor
 * @property Paket $paket
 */
class Transaksi extends \yii\db\ActiveRecord
{
    const STATUS_CONFIRM = 1;
    const STATUS_UNCONFIRM = 0;

    const STATUS_PAIDOFF = 1;
    const STATUS_EARN = 0;

    const STATUS_TAKED = 1;
    const STATUS_UNTAKE = 0;

    const STATUS_RETURN = 1;
    const STATUS_UNRETURN = 0;

    const STATUS_NOTHING = '0';
    const STATUS_KTM = 'KTM';
    const STATUS_KTP = 'KTP';
    const STATUS_PERPUS = 'PERPUS';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['transaksi_created_at','transaksi_updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['transaksi_updated_at'],
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
        return 'transaksi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaksi_start_date', 'duration'], 'required', 'message' => '{attribute} harus diisi'],
            [['paket_id', 'duration', 'customer_id'], 'integer'],
            [['transaksi_start_date', 'transaksi_return_date', 'transaksi_created_at', 'transaksi_updated_at'], 'safe'],
            ['transaksi_start_date','checkDate'],
            ['transaksi_start_date','cekDate'],
            [['motor_id', 'transaksi_id'], 'string', 'max' => 50],
            [['transaksi_id'], 'unique'],
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
            'transaksi_id' => 'Kode Reservasi',
            'motor_id' => 'Motor ID',
            'customer_id' => 'Customer',
            'paket_id' => 'Paket',
            'transaksi_start_date' => 'Waktu Ambil',
            'transaksi_return_date' => 'Waktu Kembali',
            'transaksi_created_at' => 'Waktu Transaksi',
            'transaksi_updated_at' => 'Updated Transaksi',
            'paket.title' => 'Paket',
            'motor.motor_name' => 'Motor',
            'motor.gambar' => 'Gambar Motor',
            'duration' => 'Durasi',
            'payment' => 'Biaya',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedback()
    {
        return $this->hasOne(Feedback::className(), ['transaksi_id' => 'transaksi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['transaksi_id' => 'transaksi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMotor()
    {
        return $this->hasOne(Motor::className(), ['motor_id' => 'motor_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPaket()
    {
        return $this->hasOne(Paket::className(), ['paket_id' => 'paket_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    public function getDenda()
    {
        return $this->hasOne(Denda::className(), ['transaksi_id' => 'transaksi_id']);
    }

    public function getProfit()
    {
        return $this->hasOne(Profit::className(), ['transaksi_id' => 'transaksi_id']);
    }

    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['transaksi_id' => 'transaksi_id']);
    }

    public function getKwitansi()
    {
        return $this->hasOne(Kwitansi::className(), ['transaksi_id' => 'transaksi_id']);
    }

    public function durasiHari()
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

    public function durasiMinggu()
    {
        return [
            1 => '1 minggu',
            2 => '2 minggu',
            3 => '3 minggu',
            4 => '4 minggu',
        ];
    }

    public function durasiBulan()
    {
        return [
            1 => '1 bulan',
            2 => '2 bulan',
        ];
    }

    public function durasiJam()
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

    public function isConfirmed()
    {
        return $this->status;
    }

    public function confirm()
    {
        $this->status = self::STATUS_CONFIRM;
        return $this->save(false);
    }

    public function unconfirm()
    {
        $this->status = self::STATUS_UNCONFIRM;
        return $this->save(false);
    }

    public function isPaid()
    {
        return $this->payment_status;
    }

    public function paidoff()
    {
        $this->payment_status = self::STATUS_PAIDOFF;
        return $this->save(false);
    }

    public function earn()
    {
        $this->payment_status = self::STATUS_EARN;
        return $this->save(false);
    }

    public function isPicked()
    {
        return $this->pengambilan_status;
    }

    public function take()
    {
        $this->pengambilan_status = self::STATUS_TAKED;
        return $this->save(false);
    }

    public function untake()
    {
        $this->pengambilan_status = self::STATUS_UNTAKE;
        return $this->save(false);
    }

    public function isReturned()
    {
        return $this->pengembalian_status;
    }

    public function return()
    {
        $this->pengembalian_status = self::STATUS_RETURN;
        return $this->save(false);
    }

    public function unreturn()
    {
        $this->pengembalian_status = self::STATUS_UNRETURN;
        return $this->save(false);
    }

    public function checkDate($attribute,$params){
        $today = date('Y-m-d H:i:s');
        $now = strtotime($today);
        $selectedDate = strtotime($this->transaksi_start_date);
        if($selectedDate<$now)
        {
            $this->addError($attribute,'Waktu Pengambilan sudah lewat');
        }
    }

    public function cekDate($attribute,$params){
        $today = date('Y-m-d H:i:s');
        $now = strtotime($today);
        $maxDate =  strtotime('+ 2 days', $now);
        $selectedDate = strtotime($this->transaksi_start_date);
        if($selectedDate >= $maxDate)
        {
            $this->addError($attribute,'Waktu Pengambilan tersedia maksimal 2 hari ke depan');
        }
    }

    public static function getTotal($provider, $fieldName)
    {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return $total;
    }

    public function ktm()
    {
        $this->jaminan_status = self::STATUS_KTM;
        return $this->save(false);
    }

    public function ktp()
    {
        $this->jaminan_status = self::STATUS_KTP;
        return $this->save(false);
    }

    public function perpus()
    {
        $this->jaminan_status = self::STATUS_PERPUS;
        return $this->save(false);
    }

    public function nothing()
    {
        $this->jaminan_status = self::STATUS_NOTHING;
        return $this->save(false);
    }

    // public function validateStartDate($attribute, $params) {
    //     $date = new \DateTime();
    //     date_sub($date, date_interval_create_from_date_string('today'));
    //     $minAgeDate = date_format($date, 'Y-m-d');
    //     date_sub($date, date_interval_create_from_date_string('2 days'));
    //     $maxAgeDate = date_format($date, 'Y-m-d');
    //         if ($this->$attribute > $minAgeDate) {
    //             $this->addError($attribute, 'Date is too small.');
    //         } elseif ($this->$attribute < $maxAgeDate) {
    //             $this->addError($attribute, 'Date is to big.');
    //         }
    // }

    public function checkDates()
    {
        $today = date('Y-m-d');
        $now = strtotime($today);
        $start_date = strtotime($this->transaksi_start_date);
        if (!$this->hasErrors() && $now > $start_date) {
            $this->addError('transaksi_start_date', 'Start date is not valid.');
        }
    }
}
