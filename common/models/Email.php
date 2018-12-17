<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property int $email_id
 * @property string $receiver_name
 * @property string $receiver_email
 * @property string $subject
 * @property string $content
 * @property string $attachment
 */
class Email extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email_id', 'receiver_name', 'receiver_email', 'subject', 'content', 'attachment'], 'required'],
            [['email_id'], 'integer'],
            [['content'], 'string'],
            [['receiver_name'], 'string', 'max' => 50],
            [['receiver_email'], 'string', 'max' => 200],
            [['subject', 'attachment'], 'string', 'max' => 255],
            [['email_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email_id' => 'Email ID',
            'receiver_name' => 'Receiver Name',
            'receiver_email' => 'Receiver Email',
            'subject' => 'Subject',
            'content' => 'Content',
            'attachment' => 'Attachment',
        ];
    }
}
