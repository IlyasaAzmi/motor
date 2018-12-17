<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "layanan".
 *
 * @property int $layanan_id
 * @property string $title
 * @property string $gambar
 */
class Layanan extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'layanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'title'], 'required'],
            [['layanan_id'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['gambar'], 'string', 'max' => 100],
            [['image'], 'safe'],
            [['image'], 'file', 'extensions'=>'jpg, gif, png']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'layanan_id' => 'Layanan ID',
            'title' => 'Title',
            'gambar' => 'Gambar',
        ];
    }
}
