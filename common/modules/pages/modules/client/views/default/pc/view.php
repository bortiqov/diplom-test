<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.03.2018
 * Time: 13:19
 */

use common\modules\pages\models\Pages;
use common\modules\settings\models\Settings;
use common\components\ImageQualityHelper;

?>

<?php

/* @var $this yii\web\View */

/**
 * @var $model Pages
 */

$this->title = $model->title;

$this->registerMetaTag(['property' => 'og:title', 'content' => $model->title]);
//$this->registerMetaTag(['property' => 'og:url', 'content' => $model->getLink()]);
$this->registerMetaTag(['property' => 'og:description', 'content' => mb_substr($model->description, 0, 120, 'UTF8')]);

$this->registerMetaTag(['property' => 'twitter:domain', 'content' => 'gastrotourism.uz']);
$this->registerMetaTag(['property' => 'twitter:title', 'content' => $model->title]);
//$this->registerMetaTag(['property' => 'twitter:url', 'content' => $model->getLink()]);
$this->registerMetaTag(['property' => 'twitter:description', 'content' => mb_substr($model->description, 0, 120, 'UTF8')]);

$this->registerCssFile('/assets/bbd5f3aa/css/novostiPodrobiye.css');


?>

<div class="container">

    <div class="row justify-content-center">
        <div class="col-12 row">
            <div class="col-12 col-lg-12">
                <div class="podrobnee-theme">
                    <?=$model->title?>
                </div>
                <div class="col-12 pod-card-text">
                    <?= $model->description ?>
                </div>
            </div>
        </div>

    </div>
</div>
