<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Contributor List';
?>

<div class="contributor-list">
    <h3><?= $this->title?></h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID Contributor</th>
                <th>Nama</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($contributors as $contributor):?>
            <tr>
                <td><?= $contributor->contributor_id?></td>
                <td><?= $contributor->name?></td>
                <td><?= $contributor->motorsCount?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
