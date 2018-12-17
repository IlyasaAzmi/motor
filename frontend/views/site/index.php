<?php

/* @var $this yii\web\View */
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Widget;
use kv4nt\owlcarousel\OwlCarouselWidget;


$this->title = 'U3 Motor - Beranda';
?>

<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Selamat Datang
        <?php
        if (Yii::$app->user->isGuest) {

        } else {
            echo Yii::$app->user->identity->username;
        }
        ?>
        </p>

        <h2>U3 Motor</h2><br>
        <p><a class="btn btn-elegant" href="?r=blog/view&id=ketentuan-sewa-motor">Ketentuan Sewa</a></p>
    </div>

    <?php OwlCarouselWidget::begin([
        'container' => 'div',
        'containerOptions' => [
            'id' => 'container-id',
            'class' => 'container-class'
        ],
        'pluginOptions'    => [
            'autoplay'          => true,
            'autoplayTimeout'   => 4000,
            'autoplayHoverPause'=> true,
            'items'             => 1,
            'loop'              => true,
            'itemsDesktop'      => [1199, 3],
            'itemsDesktopSmall' => [979, 3],
            'stagePadding'      => 0,
            //'nav'               => true,
            'margin'            => 0,
            'smartSpeed'        => 1000,
            'autoPlaySpeed'     => true,
        ]
    ]);
    ?>

    <?php foreach($posters as $item) { ?>
        <div class="item-class">
            <div class="view overlay hm-white-light z-depth-1-half">
                <img src="<?php echo Yii::getAlias('@posterImgUrl').'/'.'poster'.$item['gambar']?>" class="img-fluid" alt="">
                <div class="mask"></div>
            </div>
        </div>
    <?php } ?>

    <?php OwlCarouselWidget::end(); ?>

    <div class="body-content">

<!-- <?php if (!Yii::$app->user->isGuest):?>

        <div class="row">
            <div class="divider-new pt-1">
                <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s">Motor Tersedia</h2>
            </div>
        </div>


        <br>

        <div class="row mt-2">
            <?php
            $i = 0;
            foreach($motors as $item) {?>

            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 wow fadeIn" data-wow-delay="0.2s">

                <div class="card">
                    <div class="view overlay hm-white-light">
                        <img src="<?php echo Yii::getAlias('@motorImgUrl').'/'.'motor'.$item['gambar']?>" class="img-fluid" alt="">
                        <div class="mask"></div>
                    </div>

                    <div class="card-body">

                        <p class="card-text text-center"><?php echo $item['motor_name']?></p>

                        <div class="text-center"><a href="?r=transaksi%2Fcreate" class="btn btn-default">Pilih</a></div>
                    </div>
                </div>

            </div>

          <?php if (++$i == 6) break;}?>
        </div>


        <br>
        <br>


        <div class="text-center">
            <a class="btn btn-elegant" href="?r=site%2Fmotorcycle">Lihat Lainnya</a>
        </div>

<?php endif;?> -->

        <div class="row">
            <div class="divider-new pt-5">
                <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s">Tentang Kami</h2>
            </div>

            <!--Section: About-->
            <section id="about" class="text-center wow fadeIn" data-wow-delay="0.2s">
                <p>Salah satu prinsip ekonomi yang dikembangkan oleh UNIDA Gontor adalah ekonomi proteksi. Prinsip tersebut bertujuan untuk melindungi perputaran keuangan secara internal. Sehingga keuangan yang selalu berputar di dalam lingkungan kampus dapat dimanfaatkan untuk kepentingan kampus itu sendiri. Untuk mewujudkan sistem ekonomi seperti ini pihak UNIDA Gontor mendirikan unit usaha yaitu Unit Usaha UNIDA (U3).</p>
                <p>Unit usaha yang terletak di lantai dasar gedung Pascasarjana tersebut memiliki konsep yang sangat unik. Misalnya, unit usaha UNIDA tidak hanya menyediakan makanan ringan. Lebih dari itu, unit usaha UNIDA juga menyediakan aneka kebutuhan mahasiswa seperti peralatan kuliah, peralatan olah raga, kebutuhan sehari-hari, laundry, photo copy, toko buku, dan lain sebagainya.</p>
            </section>
            <!--Section: About-->
        </div>

        <div class="row">
            <div class="divider-new pt-5">
                <h2 class="h2-responsive wow fadeIn" data-wow-delay="0.2s">Layanan Lain</h2>
            </div>
        </div>

        <!--Section: Layanan-->
        <section id="layanan">
            <div class="row pt-3">
                <?php foreach($layanans as $item) { ?>
                    <div class="col-lg-4 mb-r">
                        <div class="card wow fadeIn">
                            <img class="img-fluid" src="<?php echo Yii::getAlias('@layananImgUrl').'/'.'layanan'.$item['gambar']?>" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title text-center"><?php echo $item['title']?></h4>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </section>
        <!--/Section: Layanan-->

        <div class="divider-new">
        <h2 class="h2-responsive wow fadeIn">Alamat</h2>
    </div>

    <!--Section: Contact-->
    <section id="contact pb-5">
        <div class="row">
            <!--First column-->
            <!--Featured image-->
            <div class="col-lg-6">
                <div class="view overlay hm-white-light z-depth-1-half">

                    <img src="img/u3m1.jpg" class="img-fluid" alt="">
                    <div class="mask"></div></a>
                </div>
            </div>
            <!--/.Featured image-->
            <!--/First column-->

            <!--Second column-->
            <div class="col-md-6">
              <br />
                <ul class="text-center list-unstyled">
                    <li class="wow fadeIn" data-wow-delay="0.2s"><i class="fa fa-map-marker teal-text fa-lg"></i>
                        <p>Universitas Darussalam Gontor<br>
                        Ponorogo, Jawa Timur, Indonesia</p>
                    </li>

                    <li class="wow fadeIn mt-5 pt-2" data-wow-delay="0.3s"><i class="fa fa-phone teal-text fa-lg"></i>
                        <p>+62 813 1234 5678 (Toni)</p>
                    </li>

                    <li class="wow fadeIn mt-5 pt-2" data-wow-delay="0.4s"><i class="fa fa-envelope teal-text fa-lg"></i>
                        <p><?= Html::mailto('u3motor.unida.gontor.ac.id', 'admin@example.com')?></p>
                    </li>
                </ul>
            </div>
            <!--/Second column-->

        </div>
    </section>
    <!--Section: Contact-->

    </div>
</div>
