<?php

namespace api\modules\v1\controllers;

use common\components\ApiController;
use common\models\Banner;
use common\models\search\BannerSearch;
use common\models\Service;
use common\models\ServiceSearch;

class ServiceController extends ApiController
{
    public $modelClass = Service::class;
    public $searchModel = ServiceSearch::class ;
}