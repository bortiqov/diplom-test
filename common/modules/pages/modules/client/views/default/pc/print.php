<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.03.2018
 * Time: 13:19
 */

use common\modules\settings\models\Settings;
use common\components\ImageQualityHelper;

$this->params['body-class'] = 'single-post video-post';
$this->params['title'] = $model->title;
$this->params['description'] = $model->description;
$title = $model->title;
$description = $model->description;
$content = $model->content;
//if($model->getImgFile()){
//    $image = $model->getImgFileSrc();
//}else{
//    $image ="";
//}

?>

<div class="third-content">
    <div class="third-top">
        <div class="top-info">
            <h3 class="title"><?=$title?></h3>
        </div>
    </div>
    <div class="third-text">

        <?= $description?>
    </div>
</div>
