<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\HomeAsset;
use common\widgets\Alert;
use kartik\icons\Icon;

HomeAsset::register($this);

Icon::map($this);
Icon::map($this, Icon::FA);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
        <?php

        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            // 'brandLabel' => Html::img('@web/img/logoU3.png', ['alt'=>Yii::$app->name]),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse my-navbar navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            [
                'label' => "Reservasi",
                'items' => [
                    ['label' => 'Harian', 'url' => ['/transaksi/create']],
                    ['label' => 'Jam', 'url' => ['/transaksi/jam']],
                    ['label' => 'Mingguan', 'url' => ['/transaksi/minggu']],
                    ['label' => 'Bulanan', 'url' => ['/transaksi/bulan']],
                ],
            ],
            ['label' => 'Katalog', 'url' => ['/catalog']],
            ['label' => 'Blog', 'url' => ['/blog']],
            // ['label' => 'Kontak', 'url' => ['/site/contact']],
            // ['label' => 'Riwayat', 'url' => ['/history']],
        ];
        if (Yii::$app->user->isGuest) {
            // $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Signup', 'url' => ['/user/registration/register']];
            // $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login']];
        } else {
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                [
                    'label' => "Reservasi",
                    'items' => [
                        ['label' => 'Harian', 'url' => ['/transaksi/create']],
                        ['label' => 'Jam', 'url' => ['/transaksi/jam']],
                        ['label' => 'Mingguan', 'url' => ['/transaksi/minggu']],
                        ['label' => 'Bulanan', 'url' => ['/transaksi/bulan']],
                    ],
                ],
                ['label' => 'Katalog', 'url' => ['/catalog']],
                ['label' => 'Blog', 'url' => ['/blog']],
                ['label' => 'History', 'url' => ['transaksi/history']],
                // [
                //     'label' => Yii::$app->user->identity->username,
                //     'items' => [
                //         ['label' => 'Profile', 'url' => ['/user/settings/profile']],
                //         ['label' => 'Logout', 'url' => ['/user/security/logout'],'linkOptions' => ['data-method' => 'post']],
                //     ],
                // ],

                [
                    'label' => Yii::$app->user->identity->username,
                    'items' => [
                        // ['label' => 'Profile', 'url' => ['/user/settings/profile']],
                        ['label' => 'Account', 'url' => ['/user/settings/account']],
                        ['label' => 'Logout', 'url' => ['/user/security/logout'],'linkOptions' => ['data-method' => 'post']],
                    ],
                  ],
            ];
            // $menuItems[] = '<li>'
            //     . Html::beginForm(['/site/logout'], 'post')
            //     . Html::submitButton(
            //         'Logout (' . Yii::$app->user->identity->username . ')',
            //         ['class' => 'btn btn-link logout']
            //     )
            //     . Html::endForm()
            //     . '</li>';
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
</div>

<footer id="atas">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div id="tentang">
                    <h4><strong>U3 Motor</strong></h4>
                    <p>Unit Usaha Universitas Darussalam Gontor yang menyediakan jasa layanan sewa motor</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div id="kontak">
                    <h4><strong>Hubungi Kami</strong></h4>

                    <p><i class="fa fa-phone teal-text fa-lg"></i> 0812345678</p>

                    <p><i class="fa fa-envelope teal-text fa-lg"></i> <?= Html::mailto('u3motor@unida.gontor.ac.id', 'admin@example.com') ?></p>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div id="quote">
                    <!-- <h3 class="pull-right"><strong>"Anda Menyewa Anda Beramal"</strong></h3> -->
                </div>
            </div>
        </div>
    </div>
</footer>

<footer id="bawah">
    <div class="container">
        <p class="pull-left"><b>&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></b></p>

        <!-- <p class="pull-right"><?= Yii::powered() ?></p> -->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
