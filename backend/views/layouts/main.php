<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use common\modules\language\components\Lang;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

\backend\assets\admin\ThetaAdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html style="font-size: medium !important;" lang="<?= Yii::$app->language ?>">
<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<style>
    .help-block {
        color: red;
    }
</style>
<body class="vertical-layout">
<?php $this->beginBody() ?>

<!-- Start Containerbar -->
<div id="containerbar">
    <!-- Start Leftbar -->
    <div class="leftbar">
        <!-- Start Sidebar -->
        <div class="sidebar">
            <!-- Start Logobar -->
            <div class="logobar">
                <a href="/" class="logo logo-large"><img style="width: 180px" src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                        "theta/images/logo.svg") ?>" class="img-fluid" alt="logo"></a>
                <a href="/" class="logo logo-small"><img style="width: 180px" src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                        "theta/images/logo.svg") ?>" class="img-fluid" alt="logo"></a>
            </div>
            <!-- End Logobar -->
            <!-- Start Profilebar -->
            <div class="profilebar text-center">
                <img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                    "theta/images/users/profile.svg") ?>" class="img-fluid" alt="profile">
                <div class="profilename">
                    <h5><?=\Yii::$app->user->identity->email?></h5>
                    <p>Social Media Strategist</p>
                </div>
            </div>
            <!-- End Profilebar -->
            <!-- Start Navigationbar -->
            <div class="navigationbar">
                <?php new \common\modules\menu\components\MenuAdminBackend([
                    'alias' => 'backend',
                    'without_cache' => true
                ]);
                ?>
            </div>
            <!-- End Navigationbar -->
        </div>
        <!-- End Sidebar -->
    </div>
    <!-- End Leftbar -->
    <!-- Start Rightbar -->
    <div class="rightbar">
        <!-- Start Topbar Mobile -->
        <div class="topbar-mobile">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="mobile-logobar">
                        <a href="/" class="mobile-logo"><img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                "theta/images/logo.svg") ?>" class="img-fluid" alt="logo"></a>
                    </div>
                    <div class="mobile-togglebar">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <div class="topbar-toggle-icon">
                                    <a class="topbar-toggle-hamburger" href="javascript:void();">
                                        <img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                            "theta/images/svg-icon/horizontal.svg") ?>" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                        <img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                            "theta/images/svg-icon/verticle.svg") ?>" class="img-fluid menu-hamburger-vertical" alt="verticle">
                                    </a>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="menubar">
                                    <a class="menu-hamburger" href="javascript:void();">
                                        <img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                            "theta/images/svg-icon/collapse.svg") ?>" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                        <img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                            "theta/images/svg-icon/close.svg") ?>" class="img-fluid menu-hamburger-close" alt="close">
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Topbar -->
        <div class="topbar">
            <!-- Start row -->
            <div class="row align-items-center">
                <!-- Start col -->
                <div class="col-md-12 align-self-center">
                    <div class="togglebar">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <div class="menubar">
                                    <a class="menu-hamburger" href="javascript:void();">
                                        <img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                            "theta/images/svg-icon/collapse.svg") ?>" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                        <img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                            "theta/images/svg-icon/close.svg") ?>" class="img-fluid menu-hamburger-close" alt="close">
                                    </a>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="searchbar">
                                    <form>
                                        <div class="input-group">
                                            <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <button class="btn" type="submit" id="button-addon2"><img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                                        "theta/images/svg-icon/search.svg") ?>" class="img-fluid" alt="search"></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="infobar">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <div class="languagebar">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag flag-icon-<?= \common\modules\language\models\Language::findOne(Lang::getLangId())->code?> flag-icon-squared"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
                                            <?php foreach (\common\modules\language\models\Language::find()->all() as $language): ?>
                                                <a class="dropdown-item" href="<?=\yii\helpers\Url::current(['setLang' => $language->code])?>"><i class="flag flag-icon-<?=$language->code?> flag-icon-squared"></i><?=$language->name?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php if (!\Yii::$app->user->isGuest): ?>
                                <li class="list-inline-item">
                                    <div class="profile-icon">
                                        <a href="<?=\Yii::$app->urlManager->createUrl(['site/profile'])?>" class="infobar-icon">
                                            <img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                                "theta/images/svg-icon/user.svg") ?>" class="img-fluid" alt="profile">
                                        </a>
                                    </div>
                                </li>
                                <li class="list-inline-item">
                                    <div class="profile-icon">
                                        <a href="<?=\Yii::$app->urlManager->createUrl(['site/logout'])?>" data-method="post" class="infobar-icon">
                                            <img src="<?= $this->getAssetUrl(\backend\assets\admin\ThetaAdminAsset::class,
                                                "theta/images/svg-icon/logout.svg") ?>" class="img-fluid" alt="profile">
                                        </a>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
        <!-- End Topbar -->
        <!-- Start Breadcrumbbar -->
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <?= Alert::widget() ?>
                    <h4 class="page-title"><?=$this->title?></h4>
                    <div class="breadcrumb-list">
                        <?= Breadcrumbs::widget([
                            'tag' => 'ol',
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'options' => [
                                'class' => 'breadcrumb col'
                            ],
                            'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
                            'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbbar -->
        <!-- Start Contentbar -->
        <div class="contentbar">
            <?=$content?>
        </div>
        <!-- End Contentbar -->
        <!-- Start Footerbar -->
        <div class="footerbar">
            <footer class="footer">
                <p class="mb-0">© 2020 RTECO - All Rights Reserved.</p>
            </footer>
        </div>
        <!-- End Footerbar -->
    </div>
    <!-- End Rightbar -->
</div>
<!-- End Containerbar -->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
