<?php
use yii\helpers\Html;

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "motor".
 *
 * @property string $motor_id
 * @property string $plat
 * @property string $motor_name
 * @property int $kategori_id
 * @property int $contributor_id
 * @property string $start_date
 * @property string $expired_date
 *
 * @property Contributor $contributor
 * @property Kategori $kategori
 * @property Transaksi[] $transaksis
 */
class Motor extends \yii\db\ActiveRecord
{
    public $image;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const CURRENT_STATUS_PENDING = 0;
    const CURRENT_STATUS_AVAILABLE = 10;
    const CURRENT_STATUS_BOOKED = 20;
    const CURRENT_STATUS_ONRENT = 30;

    const ENTRUST_TYPE_70 = 70;
    const ENTRUST_TYPE_50 = 50;
    const ENTRUST_TYPE_100 = 100;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
        return 'motor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['motor_id', 'plat', 'motor_name', 'kategori_id', 'contributor_id', 'start_date', 'expired_date', 'entrust_type', 'year'], 'required','message' => '{attribute} harus diisi'],
            [['kategori_id', 'contributor_id', 'year'], 'integer'],
            [['start_date', 'expired_date', 'current_status'], 'safe'],
            [['motor_id', 'plat'], 'string', 'max' => 50],
            [['motor_name', 'gambar'], 'string', 'max' => 100],
            [['image'], 'safe'],
            [['image'], 'file', 'extensions'=>'jpg, gif, png'],
            [['motor_id', 'plat'], 'unique','message' => '{attribute} sudah digunakan'],
            [['contributor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contributor::className(), 'targetAttribute' => ['contributor_id' => 'contributor_id']],
            [['kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kategori::className(), 'targetAttribute' => ['kategori_id' => 'kategori_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'motor_id' => 'Motor ID',
            'plat' => 'Plat Nomor',
            'motor_name' => 'Merk',
            'kategori_id' => 'Kategori',
            'kategori.title' => 'Kategori',
            'contributor_id' => 'Contributor',
            'contributor.name' => 'Contributor',
            'start_date' => 'Awal Sewa',
            'expired_date' => 'Akhir Sewa',
            'image' => 'Gambar',
            'status' => 'Status',
            'entrust_type' => 'Tipe Penitipan',
            'year' => 'Tahun Pembelian',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContributor()
    {
        return $this->hasOne(Contributor::className(), ['contributor_id' => 'contributor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(Kategori::className(), ['kategori_id' => 'kategori_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksis()
    {
        return $this->hasMany(Transaksi::className(), ['motor_id' => 'motor_id']);
    }

    public function getDenda()
    {
        return $this
           ->hasMany(Denda::className(), ['denda_id' => 'transaksi_id'])
           ->viaTable('transaksi', ['transaksi_id' => 'motor_id']);
    }

    public function getTransaksisCount()
    {
        return $this->hasMany(Transaksi::classname(), ['motor_id' => 'motor_id']) -> count();
    }

    function getMotorByCat($catid)
    {
        $motor = Motor::find()->asArray()
            ->where('kategori_id=:kategori_id',['kategori_id'=>$catid])
            ->all();
        return $motor;
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

    public function available()
    {
        $this->current_status = self::CURRENT_STATUS_AVAILABLE;
        return $this->save(false);
    }

    public function booked()
    {
        $this->current_status = self::CURRENT_STATUS_BOOKED;
        return $this->save(false);
    }

    public function onrent()
    {
        $this->current_status = self::CURRENT_STATUS_ONRENT;
        return $this->save(false);
    }

}
