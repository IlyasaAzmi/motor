<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Motor List';
?>

<div class="motor-list">
    <h3><?= $this->title?></h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Plat</th>
                <th>Title</th>
                <th>Tanggal</th>
                <th>Gambar</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($motors as $motor):?>
            <tr>
                <td><?= $motor->motor_id?></td>
                <td><?= $motor->plat?></td>
                <td><?= $motor->motor_name?></td>
                <td><?= Yii::$app->formatter->asDate($motor->start_date, 'php:d-M-Y')?></td>
                <td><img src="<?php echo Yii::getAlias('@motorImgUrl').'/'.'motor'.$motor->gambar?>"width="50"></td>


                <td>
                    <?php if($motor->isActived()):?>
                        <a class="btn btn-warning" href="<?= Url::toRoute(['motor/inactive', 'id'=>$motor->motor_id]);?>">Inactive</a>
                        <?php else:?>
                            <a class="btn btn-success" href="<?= Url::toRoute(['motor/active', 'id'=>$motor->motor_id]);?>">Active</a>
                        <?php endif?>
                    <!-- <a class="btn btn-danger" href="<?= Url::toRoute(['motor/delete', 'id'=>$motor->motor_id]);?>">Delete</a> -->
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
