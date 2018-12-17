<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $blog->title;
$this->params['breadcrumbs'][] = ['label' => 'Blog', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="blog-view">
    <h2><?= Html::encode($this->title) ?></h2>
    <br />
    <div class="col-lg-12">
        <img src="<?php echo Yii::getAlias('@blogImgUrl').'/'.'blog'.$blog->gambar?>" width="500" height="auto">
    </div>

    <div class="col-lg-12">
        <p>
            <?=$blog->text?>
        </p>
    </div>
</div>
