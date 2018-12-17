<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "poster".
 *
 * @property int $poster_id
 * @property string $title
 * @property string $gambar
 */
class Poster extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poster';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poster_id', 'title'], 'required'],
            [['poster_id'], 'integer'],
            [['title', 'gambar'], 'string', 'max' => 100],
            [['image'], 'safe'],
            [['image'], 'file', 'extensions'=>'jpg, gif, png'],
            [['poster_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'poster_id' => 'Poster ID',
            'title' => 'Title',
            'gambar' => 'Gambar',
        ];
    }
}
