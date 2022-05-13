<?php

namespace api\modules\admin\controllers;

use backend\modules\admin\v1\forms\PostForm;
use common\models\Partner;
use common\models\search\PartnerSearch;
use common\models\Service;
use common\models\ServiceSearch;
use common\modules\post\models\Post;
use common\modules\post\models\search\PostSearch;
use Yii;

class PartnerController extends \common\components\CrudController
{
    public $modelClass = Partner::class;
    public $searchModel = PartnerSearch::class;


}