<?php
namespace backend\models;

use Yii;
use yii\base\Model;

class DateForm extends Model
{
    public $bulan;
    public $tahun;

    public function rules()
    {
        return[
            [['bulan', 'tahun'], 'required'],
            ['bulan', 'string'],
        ];
    }
}
