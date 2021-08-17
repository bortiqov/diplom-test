<?php

/**
 * @var $model \common\modules\pages\models\Pages
 */

$this->params['body-class'] = 'single-post video-post';
$this->params['title'] = $model->SeoInfo("title");
$this->params['description'] = $model->SeoInfo("description");
$this->params['image'] = $model->seoImage;

$title = $model->title;
$description = $model->description;
$categories = $model->categoriesPrint;
$content = $model->content;
$image = $model->getImgFileSrc();


$last_query = \common\modules\posts\models\Posts::find()->last()->limit(4);
$last = $last_query->all();
?>

<?php if(Yii::$app->view->beginCache('posts-views',\common\modules\pages\models\Pages::cacheFragmentParams())): ?>
    <div class="itv-header">
        <h1 class="title-itv">
            <?=$title?>
        </h1>
        <div class="itv-cate">
            <?=$model->getCategoriesPrintTag("a","itv-cat left")?>
            <div class="data-itv right"><?=$model->date_publish?></div>
            <div class="clear"></div>
        </div>
    </div>

    <?php if($model->videos):?>
        <?php $video_file = $model->videoFile;?>
        <?php if($video_file->source_type == \common\modules\videos\models\Videos::TYPE_FILE):?>
            <div class="video-con">
                <?php if($video_file->files):?>
                    <?php echo Yii::$app->view->render('@common/modules/videos/modules/client/views/default/_player',['video' => $video_file->files[0],'class' => 'col-md-12 video-js vjs-default-skin main-player']);?>
                <?php endif;?>
            </div>
        <?php elseif($video_file->source_type == \common\modules\videos\models\Videos::TYPE_IFRAME):?>
            <div class="video-con">
                <?=$video_file->source_data?>
            </div>
        <?php elseif($video_file->source_type == \common\modules\videos\models\Videos::TYPE_YOUTUBE):?>
            <div class="video-con">
                <iframe width="640" height="360" src="<?=$video_file->youtube()?>" frameborder="0" allowfullscreen></iframe>
            </div>
        <?php elseif($video_file->source_type == \common\modules\videos\models\Videos::TYPE_MOVER):?>
            <div class="video-con">
                <iframe width="640" height="360" src="<?=$video_file->mover()?>" frameborder="0" allowfullscreen></iframe>
            </div>
        <?php elseif($video_file->source_type == \common\modules\videos\models\Videos::TYPE_MYTUBE):?>
            <div class="video-con">
                <iframe width="640" height="360" src="<?=$video_file->mytube()?>" frameborder="0" allowfullscreen></iframe>
            </div>
        <?php elseif($video_file->source_type == \common\modules\videos\models\Videos::TYPE_IFRAME_SOURCE):?>
            <div class="video-con">
                <iframe width="640" height="360" src="<?=$video_file->source_data?>" frameborder="0" allowfullscreen></iframe>
            </div>
        <?php elseif($video_file->source_type == \common\modules\videos\models\Videos::TYPE_FILE_SOURCE):?>
            <?php echo Yii::$app->view->render('@common/modules/videos/modules/client/views/default/_player',['video' => $video_file->source_data,'class' => 'col-md-12 video-js vjs-default-skin main-player']);?>
        <?php endif;?>
    <?php else:?>
        <div class="single-post__img" style="background-image:url(<?=$image?>);"></div>
    <?php endif;?>
    <div class="single-post__socials">
        <div class="addthis_inline_share_toolbox_91tz social-share-block"></div>
    </div>


    <div class="single-post__tags">
        <ul>
            <?=$model->tagsPrint("a","li","")?>
        </ul>
    </div>


    <div class="single-post__content">
        <?=$model->content?>
    </div>

    <div class="itv-read-more">
        <h3 class="itv-read-more-title"><?=_l('Last posts')?></h3>
        <?php
        $last_query = \common\modules\posts\models\Posts::find()->last()->limit(4);
        $last = $last_query->all();
        ?>
        <?php foreach ($last as $last_element):?>
            <article class="itv-read-more-card">
                <a href="<?=$last_element->singleLink?>" class="title-itv">
                    <?=$last_element->title?>
                </a>
                <div class="itv-cate">
                    <?=$model->getCategoryPrintTag("a","itv-cat left")?>
                    <div class="data-itv right"><?=$last_element->date_publish?></div>
                    <div class="clear"></div>
                </div>
            </article>
        <?php endforeach;?>
    </div>
<?php endif;?>
