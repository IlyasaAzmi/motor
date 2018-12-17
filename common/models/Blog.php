<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\base\Event;

/**
 * This is the model class for table "blog".
 *
 * @property int $blog_id
 * @property string $title
 * @property string $text
 * @property int $slug
 * @property string $gambar
 * @property string $created_at
 * @property string $updated_at
 */
class Blog extends \yii\db\ActiveRecord
{
    public $image;

    //ad status variable
    const STATUS_PENDING = 1;
    const STATUS_PUBLISH = 0;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_id', 'title', 'text', 'status'], 'required'],
            [['blog_id'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'gambar', 'slug'], 'string', 'max' => 100],
            [['blog_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'blog_id' => 'Blog ID',
            'title' => 'Title',
            'text' => 'Text',
            'slug' => 'Slug',
            'gambar' => 'Gambar',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status'
        ];
    }

    //get new Status
    // public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert)) {
    //         if ($this->isNewRecord) {
    //             $this->status = self::STATUS_DISALLOW;
    //         }
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    //get status method
    // public static function getStatuses()
    // {
    //     return [
    //         self::STATUS_DONE => 'Done',
    //         self::STATUS_IN_PROGRESS => 'In progress',
    //         self::STATUS_NEW => 'New',
    //     ];
    // }

    //methd for sending Email
    public function sendEmail()
    {
        return Yii::$app->mailer->compose('order', ['order' => $this])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('New order #' . $this->id)
            ->send();
    }

    CONST EVENT_OUR_CUSTOM_EVENT = 'eventOurCustomEvent';

    public function isAllowed()
    {
        return $this->status;
    }

    public function allow()
    {
        $this->status = self::STATUS_PUBLISH;
        return $this->save(false);
    }

    public function disallow()
    {
        $this->status = self::STATUS_PENDING;
        return $this->save(false);
    }
}
