<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

\backend\assets\admin\AdminEmptyAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>

        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

        <style>
            .
        </style>

    </head>
    <body class="bg-default">
    <?php $this->beginBody() ?>

    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8" style="background: linear-gradient(87deg, #fcd787 0, #f6c55b 100%) !important">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
<!--                            <h1 class="text-white">Welcome!</h1>-->
<!--                            <p class="text-lead text-light">Use these awesome forms to login or create new account in your project for free.</p>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <!-- Page content -->
        <?= Alert::widget() ?>


        <div class="container mt--8 pb-5">
            <div class="card bg-secondary shadow border-0">
                <div class="card-header bg-transparent pb-5">
                    <div class="btn-wrapper text-center pt-5">
                        <img src="<?=$this->getAssetUrl(\backend\assets\admin\AdminAsset::class, "img/logo.png")?>" />
                    </div>
                </div>
                <div class="card-body px-lg-5 py-lg-4">
                    <?= $content ?>

                </div>
            </div>
        </div>

        <footer class="py-5">
            <div class="container" style="text-align: center;">
                <div class="row align-items-center justify-content-xl-between">
                    <div style="margin: 0 auto;">
                        <div class="copyright text-center text-xl-left text-muted">
                            © <?=date('Y')?> <a href="https://rteco.uz" class="font-weight-bold ml-1" target="_blank">O'zbekkonsert davlat muassasasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>

