<?php

namespace api\modules\admin\controllers;

use backend\modules\admin\v1\forms\PostForm;
use common\models\Banner;
use common\models\search\BannerSearch;
use common\models\Service;
use common\models\ServiceSearch;
use common\modules\post\models\Post;
use common\modules\post\models\search\PostSearch;
use Yii;

class BannerController extends \common\components\CrudController
{
    public $modelClass = Banner::class;
    public $searchModel = BannerSearch::class;


}