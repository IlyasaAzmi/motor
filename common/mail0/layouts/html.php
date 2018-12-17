<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message beong composed *?
/* @var $content string main view render result */
$logoLink = Url::to('/images/logoU3.png', true);
?>

<?php $this->beginPage()?>
<!DOCTYPE html PUBLIC "-//W3C//DD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=<?=Yii::$app->charset?>" />
        <title><?= Html::encode($this->title)?></title>
        <?php $this->head()?>
    </head>
    <body>
        <?php $this->beginBody()?>
        <?$content ?>
        <?php $this->endBody()?>
    </body>
</html>
<?php $this->endPage()?>
