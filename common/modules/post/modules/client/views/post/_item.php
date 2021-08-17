<?php

/* @var $this yii\web\View */
/* @var $widget yii\web\View */
/* @var $model \common\modules\post\models\Post */
?>
<?php $widget->itemOptions['class'] = 'col-12 col-sm-6 col-md-4  mb-3 pr-0 pr-sm-3'; ?>
<a href="<?= $model->getLink() ?>" class="card">
    <div class="card-img">
        <img class="img-fluid" src="<?= $model->picture->getSrc('medium') ?>"
             alt="shkola Gastrotourism">
    </div>
    <div class="card-body">
        <?= $model->anons ?>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <div><img src="/images/Line.svg" alt="line"></div>
        <div class="d-flex align-items-center"><img src="/images/eye.svg"
                                                    alt="eye"><span><?= $model->viewed ?></span>
        </div>
    </div>
</a>
