<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Overview';
?>
<div class="site-index">

    <h1>Overview</h1>
    <!-- <div class="jumbotron">

        <p class="lead">Halaman Backend Admin</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div> -->

    <div class="body-content">
        <!-- <div class="row"> -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo Yii::t('app', 'Motor');?></strong></div>
                    <div class="panel-body">
                        <a class="btn btn-primary" style="width:200px;" href="<?= Url::toRoute(['motor/actived']);?>">Motor Aktif <span class="badge"><?= $actived;?></span></a>
                        <a class="btn btn-danger" style="width:200px;" href="<?= Url::toRoute(['motor/inactived']);?>">Motor Non-Aktif <span class="badge"><?= $inactived;?></span></a>
                        <p><br />
                            Keterangan:
                            <ul>
                                <li>
                                    <b>Motor Aktif</b>: Motor yang tersedia dan siap disewa
                                </li>
                                <li>
                                    <b>Motor Non Aktif</b>: Motor yang tidak tersedia untuk disewa
                                </li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo Yii::t('app', 'Motor Terbaru');?></strong></div>
                    <div class="panel-body">
                      <table class="table table-hover">
                          <thead class="bg bg-default">
                              <tr>
                                  <th>ID Motor</th>
                                  <th>Merk</th>
                                  <th>Contributor</th>
                                  <th>Detail</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              $i = 0;
                              foreach($motors as $items) :?>
                              <tr>
                                  <!-- <td><?= $items->motor_id?></td> -->
                                  <td>
                                      <?php if($items->isActived()):?>
                                          <span class="label label-primary"><?= $items->motor_id?></span>
                                          <?php else:?>
                                              <span class="label label-danger"><?= $items->motor_id?></span>
                                          <?php endif?>
                                  </td>
                                  <td><?= $items->motor_name?></td>
                                  <td><?= $items->contributor->name?></td>
                                  <td><a class="label label-default" href="<?= Url::toRoute(['/motor/view','id'=>$items->motor_id]);?>">Lihat</a></td>
                              </tr>
                              <?php if (++$i == 3) break;?>
                              <?php endforeach;?>
                          </tbody>
                      </table>
                      <a class="btn btn-default pull-right" href="<?= Url::toRoute(['/motor/index']);?>">Selengkapnya <span class="badge"><?= $sepeda;?></span></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo Yii::t('app', 'Transaksi');?></strong></div>
                    <div class="panel-body">

                        <a class="btn btn-success" style="width:200px;" href="<?= Url::toRoute(['transaksi/confirmed']);?>">Transaksi Berhasil <span class="badge"><?= $confirmed;?></span></a>
                        <a class="btn btn-warning" style="width:200px;" href="<?= Url::toRoute(['transaksi/unconfirmed']);?>">Transaksi On Progress <span class="badge"><?= $unconfirmed;?></span></a>

                        <p>
                            <ul>
                                <li>
                                    <b>Transaksi Berhasil</b>: Transaksi yang sudah selesai seluruh proses administrasi sewa (pembayaran, pengambilan, dan pengembalian)
                                </li>
                                <li>
                                    <b>Transaksi On Progress</b>: Transaksi yang masih dalam proses administrasi sewa (contoh: belum melakukan pembayaran, belum mengambil, atau belum mengembalikan)
                                </li>
                            </ul>
                        </p>
                        <hr />


                        <a class="btn btn-info" style="width:200px;" href="<?= Url::toRoute(['transaksi/paidoffed']);?>">Lunas <span class="badge"><?= $paidoff;?></span></a>
                        <a class="btn btn-danger" style="width:200px;" href="<?= Url::toRoute(['transaksi/earned']);?>">Tunggakan <span class="badge"><?= $earn;?></span></a>

                        <p>
                            <ul>
                                <li>
                                    <b>Lunas</b>: Transaksi yang sudah melakukan pembayaran
                                </li>
                                <li>
                                    <b>Tunggakan</b>: Transaksi yang belum melakukan pembayaran
                                </li>
                            </ul>
                        </p>
                        <hr />

                        <a class="btn btn-default" style="width:200px;" href="<?= Url::toRoute(['transaksi/untaked']);?>">Belum Diambil <span class="badge"><?= $untaked;?></span></a>
                        <a class="btn btn-primary" style="width:200px;" href="<?= Url::toRoute(['transaksi/ongoing']);?>">Sewa <span class="badge"><?= $ongoing;?></span></a>

                        <p>
                            <ul>
                                <li>
                                    <b>Belum Diambil</b>: Transaksi yang belum sudah melakukan pembayaran namun belum mengambil motor
                                </li>
                                <li>
                                    <b>Sewa</b>: Transaksi dalam proses sewa (sudah dibayar dan diambil, namun belum dikembalikan)
                                </li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo Yii::t('app', 'Transaksi Terakhir');?></strong></div>
                    <div class="panel-body">
                      <table class="table table-hover">
                          <thead class="bg bg-default">
                              <tr>
                                  <th>Kode</th>
                                  <th>Motor</th>
                                  <th>Customer</th>
                                  <th>Biaya</th>
                                  <th>Detail</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              $i = 0;
                              foreach($transaksis as $item) :?>
                              <tr>
                                  <td>
                                      <?php if($item->isConfirmed()):?>
                                          <span class="label label-success"><?= $item->transaksi_id?></span>
                                          <?php else:?>
                                              <span class="label label-warning"><?= $item->transaksi_id?></span>
                                          <?php endif?>
                                  </td>
                                  <td>
                                      <?php if(!empty($item->motor_id)):?>
                                      <?= $item->motor->motor_name?> (<?= $item->motor_id?>)
                                      <?php else:?>
                                          <span class="label label-danger"><?= Html::encode('Belum dipilih')?></span>
                                      <?php endif?>
                                  </td>
                                  <td><?= $item->user->profile->name?></td>
                                  <!-- <td>
                                      <?php if($item->isPicked()):?>
                                          <span class="label label-primary"><?= Yii::$app->formatter->asDatetime($item->transaksi_start_date)?></span>
                                          <?php else:?>
                                              <span class="label label-default"><?= Yii::$app->formatter->asDatetime($item->transaksi_start_date)?></span>
                                          <?php endif?>
                                  </td> -->
                                  <td>
                                      <?php if($item->isPaid()):?>
                                          <span class="label label-info"><?= Yii::$app->formatter->asCurrency($item->payment)?></span>
                                          <?php else:?>
                                              <span class="label label-danger"><?= Yii::$app->formatter->asCurrency($item->payment)?></span>
                                          <?php endif?>
                                  </td>
                                  <td><a class="btn btn-default" href="<?= Url::toRoute(['/transaksi/view','id'=>$item->transaksi_id]);?>">Lihat</a></td>
                              </tr>
                              <?php if (++$i == 8) break;?>
                              <?php endforeach;?>
                          </tbody>
                      </table>
                      <a class="btn btn-default pull-right" href="<?= Url::toRoute(['/transaksi/index']);?>">Selengkapnya <span class="badge"><?= $reservasi;?></span></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo Yii::t('app', 'Feedback Terbaru');?></strong></div>
                    <div class="panel-body">
                      <table class="table table-hover">
                          <thead class="bg bg-info">
                              <tr>
                                  <th>Kode</th>
                                  <th>Motor</th>
                                  <th>Note</th>
                                  <th>Detail</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              $i = 0;
                              foreach($feedbacks as $item) :?>
                              <tr>
                                  <td><?= Html::a($item->transaksi_id, ['/transaksi/view', 'id' => $item->transaksi_id]) ?></td>
                                  <td><?= Html::a($item->transaksi->motor->motor_id.' - '.$item->transaksi->motor->motor_name, ['/motor/view', 'id' => $item->transaksi->motor->motor_id]) ?></td>
                                  <td><?= $item->note?></td>
                                  <td><a class="btn btn-default" href="<?= Url::toRoute(['/feedback/view','id'=>$item->feedback_id]);?>">Lihat</a></td>
                              </tr>
                              <?php if (++$i == 5) break;?>
                              <?php endforeach;?>
                          </tbody>
                      </table>
                      <a class="btn btn-default pull-right" href="<?= Url::toRoute(['/feedback/index']);?>">Selengkapnya</span></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><?php echo Yii::t('app', 'Denda Terbaru');?></strong></div>
                    <div class="panel-body">
                      <table class="table table-hover">
                          <thead class="bg bg-info">
                              <tr>
                                  <th>Kode</th>
                                  <th>Motor</th>
                                  <th>Note</th>
                                  <th>Biaya</th>
                                  <th>Detail</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              $i = 0;
                              foreach($dendas as $item) :?>
                              <tr>
                                  <td><?= Html::a($item->transaksi->transaksi_id, ['/transaksi/view', 'id' => $item->transaksi_id]) ?></td>
                                  <td><?= Html::a($item->transaksi->motor->motor_id.' - '.$item->transaksi->motor->motor_name, ['/motor/view', 'id' => $item->transaksi->motor->motor_id]) ?></td>
                                  <td><?= $item->note?></td>
                                  <!-- <td><?= $item->charge?></td> -->
                                  <td><?= Yii::$app->formatter->asCurrency($item->charge)?></td>
                                  <!-- <td><a class="btn btn-default" href="<?= Url::toRoute(['/transaksi/view','id'=>$item->transaksi_id]);?>">Lihat</a></td> -->
                                  <td><?= Html::a('Lihat', ['/denda/view', 'id' => $item->denda_id], ['class' => 'btn btn-default']) ?></td>
                              </tr>
                              <?php if (++$i == 5) break;?>
                              <?php endforeach;?>
                          </tbody>
                      </table>
                      <a class="btn btn-default pull-right" href="<?= Url::toRoute(['/denda/index']);?>">Selengkapnya</span></a>
                    </div>
                </div>
            </div>

        <!-- </div> -->
    </div>
</div>
