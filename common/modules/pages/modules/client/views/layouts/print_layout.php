<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use \common\modules\settings\models\Settings;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <?php $this->registerJs("window.print();"); ?>
</head>
<body>
<?php $this->beginBody() ?>

<body style="width: 680px;">
<div class="container df" style="padding: 20px; padding-left: 0px;">
    <a href="/">
        <div>
            <img src="<?=Settings::value('menu-logo')[0]->src?>" />
        </div>
    </a>
</div>
<main role="main">
    <?= $content ?>
</main>
<footer>
    <div class="copyright-container">
        <div class="container">
            <div class="copyright">
                2006 – <?=date('Y')?> © uzbekkonsert.uz
            </div>
            <div class="author" style="width: 400px">
                <a href="https://rteco.uz">Разработано в rteco.uz</a>
            </div>
        </div>
    </div>
</footer>

</body>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
