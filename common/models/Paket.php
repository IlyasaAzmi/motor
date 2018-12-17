<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paket".
 *
 * @property int $paket_id
 * @property string $title
 * @property int $price
 */
class Paket extends \yii\db\ActiveRecord
{
    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paket_id', 'title', 'price'], 'required'],
            [['paket_id', 'price'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['image'], 'safe'],
            [['image'],'file', 'extensions'=>'jpg, gif, png'],
            [['paket_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'paket_id' => 'Paket ID',
            'title' => 'Title',
            'price' => 'Price',
            'image' => 'Gambar',
        ];
    }
}
