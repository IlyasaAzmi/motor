<?php

namespace common\components\flaghelper;
use Yii;
/**
*
*/
class MotorStatusFlag
{
    const MOTOR_PENDING = 0;
    const MOTOR_ACTIVE = 1;
    const MOTOR_INACTIVE = 2;
    const MOTOR_CLOSED = 3;

    public static function getMotorStatusFlagList()
    {
        return [
            self::MOTOR_PENDING => Yii::t('app', 'Motor Pending'),
            self::MOTOR_ACTIVE => Yii::t('app', 'Motor Active'),
            self::MOTOR_INACTIVE => Yii::t('app', 'Motor Disabled'),
            self::MOTOR_CLOSED => Yii::t('app', 'Motor Closed'),
        ];
    }

}
