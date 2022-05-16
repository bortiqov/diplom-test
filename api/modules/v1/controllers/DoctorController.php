<?php

namespace api\modules\v1\controllers;

use common\components\ApiController;
use common\models\Banner;
use common\models\Doctor;
use common\models\search\BannerSearch;
use common\models\search\DoctorSearch;
use common\models\Service;
use common\models\ServiceSearch;

class DoctorController extends ApiController
{
    public $modelClass = Doctor::class;
    public $searchModel = DoctorSearch::class;
}