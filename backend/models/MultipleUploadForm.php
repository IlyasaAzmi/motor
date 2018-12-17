<?php

namespace backend\models;

use yii\base\Model;
use yii\web\UploadFile;

class MultipleUploadForm extends Model
{
    /**
    * @var UplaodedFile[] files uploaded
    */
    public $files;

    /**
    * @return array the validation here
    */
    public function rules()
    {
        return [
            [['files'], 'file', 'extensions' => 'jpg', 'mimeTypes' => 'image/jpeg', 'maxFiles' => 10, 'skiponEmpty' => false],
        ];
    }
} ?>
