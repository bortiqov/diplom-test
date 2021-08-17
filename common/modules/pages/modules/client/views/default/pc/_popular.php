<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.03.2018
 * Time: 14:12
 */
$last_query = \common\modules\posts\models\Posts::find()->popular()->limit(4);
$last = $last_query->all();
?>

<div class="article-post">
    <div class="widgetitle">
        <h5><?=Yii::t('yoshlar-posts','Most popular')?></h5>
    </div>
    <ul>
        <?php if($last_query->count() > 0):?>
            <?php foreach ($last as $model):?>
                <?php
                $title = Yii::$app->tools->wordsCut($model->title);
                $categories = $model->categoryPrint;
                $duration =  Yii::$app->formatter->asDuration(strtotime(date("d.m.Y",time()-strtotime($model->date_publish))));
                $link = $model->singleLink;
                if($model->imgFile){
                    $img = $model->imgFile->src('low');
                }else{
                    $img ="";
                }
                $view = $model->views;
                ?>
                <li class="article-post__item flex-row space-between">
                    <div class="article-post__item-poster"><span class="article-post__item-poster-inner" style="background-image:url(<?=$img?>)"></span>
                    </div>
                    <div class="article-post__item-info">
                        <a href="<?=$link?>">
                            <div class="article-post__item-title"><?=$title?></div>
                        </a>
                        <div class="article-post__item-footer flex-row aic space-between">
                            <?php if(count($model->categories)):?>
                                <div class="article-post__item-category">
                                   <?=$categories?>
                                </div>
                            <?php endif;?>
                            <a href="">
                                <div class="article-post__item-view"><?=$view?></div>
                            </a>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
</div>
