<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class HourForm extends Model
{
    public $start;
    public $duration;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start', 'duration'], 'required'],
            [['duration'], 'integer'],
            [['start'], 'safe'],
            ['start','checkDate'],
            ['start','cekDate'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'start' => 'Waktu Pengambilan',
            'duration' => 'Durasi',
        ];
    }

    public function hourDuration()
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

    public function checkDate($attribute,$params){
        $today = date('Y-m-d H:i:s');
        $now = strtotime($today);
        $selectedDate = strtotime($this->start);
        if($selectedDate<$now)
        {
            $this->addError($attribute,'Waktu Pengambilan sudah lewat');
        }
    }

    public function cekDate($attribute,$params){
        $today = date('Y-m-d H:i:s');
        $now = strtotime($today);
        $maxDate =  strtotime('+ 2 days', $now);
        $selectedDate = strtotime($this->start);
        if($selectedDate >= $maxDate)
        {
            $this->addError($attribute,'Waktu Pengambilan tersedia maksimal 2 hari ke depan');
        }
    }
}
