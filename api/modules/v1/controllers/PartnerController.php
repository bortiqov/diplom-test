<?php

namespace api\modules\v1\controllers;

use common\components\ApiController;
use common\models\Banner;
use common\models\Partner;
use common\models\search\BannerSearch;
use common\models\search\PartnerSearch;
use common\models\Service;
use common\models\ServiceSearch;

class PartnerController extends ApiController
{
    public $modelClass = Partner::class;
    public $searchModel = PartnerSearch::class;
}