<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\helpers\Markdown;


$this->title = 'Motor List';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1><br>

<table class="table table-hover">
    <tr class="success">
        <th>ID</th>
        <th>Plat</th>
        <th>Title</th>
        <th>Tanggal</th>
        <th>Gambar</th>
    </tr>
    <?php foreach($motors as $item) { ?>
    <tr>
        <td><?php echo $item['motor_id'] ?></td>
        <td><?php echo $item['plat'] ?></td>
        <td><?php echo $item['motor_name'] ?></td>
        <td><?php echo Yii::$app->formatter->asDate($item['start_date'], 'php:d-M-Y') ?></td>
        <td> <img src="<?php echo Yii::getAlias('@motorImgUrl').'/'.'motor'.$item['gambar']?>" width="50" height="auto"></img></td>
    </tr>
<?php } ?>
</table>
