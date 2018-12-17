<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
        // $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login']];
    } else {
        $menuItems = [
            ['label' => 'Overview', 'url' => ['/site/index']],
            // ['label' => 'Dashboard', 'url' => ['/transaksi/grafik']],
            // [
            //     'label' => "Analysis",
            //     'items' => [
            //         ['label' => 'Motor', 'url' => ['/motor'],
            //             'items' => [
            //                 ['label' => 'Motor', 'url' => ['/motor']],
            //                 ['label' => 'Transaksi', 'url' => ['/transaksi']],
            //                 ['label' => 'Contributor', 'url' => ['/contributor']],
            //                 ['label' => 'Customer', 'url' => ['/user']],
            //                 ['label' => 'Income', 'url' => ['/income']],
            //             ],
            //         ],
            //         ['label' => 'Transaksi', 'url' => ['/transaksi']],
            //         ['label' => 'Contributor', 'url' => ['/contributor']],
            //         ['label' => 'Customer', 'url' => ['/user']],
            //         ['label' => 'Income', 'url' => ['/income']],
            //     ],
            // ],
            // [
            //     'label' => "Analysis",
            //     'items' => [
            //         ['label' => 'Motor', 'url' => ['/motor/grids']],
            //         ['label' => 'Transaksi', 'url' => ['/transaksi/grids']],
            //         ['label' => 'Income', 'url' => ['/transaksi/income']],
            //     ],
            // ],
            [
                'label' => "Manajemen",
                'items' => [
                    ['label' => 'Motor', 'url' => ['/motor']],
                    ['label' => 'Transaksi', 'url' => ['/transaksi']],
                    ['label' => 'Contributor', 'url' => ['/contributor']],
                    // ['label' => 'Customer', 'url' => ['/user']],
                    ['label' => 'Customer', 'url' => ['/user/admin/index']],
                    ['label' => 'Income', 'url' => ['/transaksi/income']],
                    ['label' => 'Rekap Bulanan', 'url' => ['/transaksi/date']],
                    ['label' => 'Kategori Motor', 'url' => ['/kategori']],
                    ['label' => 'Denda', 'url' => ['/denda']],
                    ['label' => 'Blog', 'url' => ['/blog']],
                    ['label' => 'Profit', 'url' => ['/profit']],
                    // ['label' => 'Poster', 'url' => ['/poster']],
                    // ['label' => 'Layanan', 'url' => ['/layanan']],
                    // ['label' => 'Email', 'url' => ['/email']],
                ],
            ],
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

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
