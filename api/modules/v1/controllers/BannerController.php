<?php

namespace api\modules\v1\controllers;

use common\components\ApiController;
use common\models\Banner;
use common\models\search\BannerSearch;

class BannerController extends ApiController
{
    public $modelClass = Banner::class;
    public $searchModel = BannerSearch::class;
}