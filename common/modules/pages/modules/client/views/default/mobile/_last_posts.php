<?php

/**
 * @var $last \common\modules\pages\models\Pages[]
 */

$last_query = \common\modules\posts\models\Posts::find()->last()->limit(4);
$last = $last_query->all();
?>
<div class="article-post recent-video be-interested">
    <div class="widgetitle">
        <h5><?=_l('Last posts')?></h5>
    </div>
    <ul>
        <?php if($last_query->count() > 0):?>
            <?php foreach ($last as $model):?>
            <?php
            $title = Yii::$app->tools->wordsCut($model->title);
            $categories = $model->categoriesPrintTag;
            $duration =  Yii::$app->formatter->asDuration(strtotime(date("d.m.Y",time()-strtotime($model->date_publish))));
            $link = $model->singleLink;
            $img = $model->getImgFileSrc();
            $view = $model->views;
            ?>
            <li class="article-post__item">
                <a href="<?=$link?>">
                    <div class="article-post__item-poster"><span class="article-post__item-poster-inner" style="background-image:url(<?=$img?>)"></span>
                    </div>
                </a>
                <a href="">
                    <div class="article-post__item-info">
                        <div class="article-post__item-title"><?=$title?></div>
                    </div>
                </a>
                <div class="article-post__item-footer flex-row aic">
                    <?php if(count($model->categories)):?>
                        <div class="article-post__item-category"><?=$categories?>
                        </div>
                    <?php endif;?>
                    <div class="article-post__item-date"><?=$duration?></div>
                    <a href="">
                        <div class="article-post__item-view"><?=$view?></div>
                    </a>
                </div>
            </li>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
</div>
