<?php

namespace api\modules\admin\controllers;

use backend\modules\admin\v1\forms\PostForm;
use common\models\Service;
use common\models\ServiceSearch;
use common\modules\post\models\Post;
use common\modules\post\models\search\PostSearch;
use Yii;

class ServiceController extends \common\components\CrudController
{
    public $modelClass = Service::class;
    public $searchModel = ServiceSearch::class;


}