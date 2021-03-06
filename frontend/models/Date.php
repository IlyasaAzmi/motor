<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class Date extends Model
{
    public $start_date;
    public $duration;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date', 'duration'], 'required'],
            [['duration'], 'integer'],
            [['start_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'start_date' => 'Waktu Mulai',
            'return_date' => 'Waktu Pengembalian',
            'duration' => 'Durasi',
        ];
    }

    public function dataDurasi()
    {
        return [
            1 => '1 hari',
            2 => '2 hari',
            3 => '3 hari',
            4 => '4 hari',
            5 => '5 hari',
            6 => '6 hari',
            7 => '7 hari',
            8 => '8 hari',
            9 => '9 hari',
            10 => '10 hari',
        ];
    }
}
