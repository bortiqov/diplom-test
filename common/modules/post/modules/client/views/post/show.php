<?php /** @var $model \common\modules\course\models\Course */
/** @var $dataProvider */
//var_dump($model->image->getImageThumbs()['full']);
//die();
?>

<div class="container-fluid">
    <div class="col-12 row my-5">
        <ul class="inside-nav nav">
            <li class="nav-item">
                <a href="/">
                    <?= __('Главная') ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= \yii\helpers\Url::to(['/post'])?>">
                    <?= __('Новости') ?>
                </a>
            </li>
        </ul>
    </div>
    <div class="row urok-page">
        <div class="col-12 row justify-content-between my-5">
            <div class="col-12 col-md-7 row">
                <div class="kurs-video col-12 row mb-5">
                    <div class="col-12">
                        <?php if ($model->photo): ?>
                            <img src="<?= $model->image->getSrc('medium') ?>" alt="">
                        <?php else: ?>
                            <img src="/images/logo.png" alt="default">
                        <?php endif; ?>

                    </div>
                </div>
                <div class="col-12 first-color">
                    <div class="card-title "><?= $model->title[Yii::$app->language] ?></div>
                    <div class="card-desc"><?= $model->description[Yii::$app->language] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>