<?php

namespace api\modules\v1\controllers;

use common\components\CrudController;
use common\models\DoctorSubscription;
use common\models\search\BannerSearch;
use common\models\search\DoctorSubscriptionSearch;

class DoctorSubscriptionController extends CrudController
{
    public $modelClass = DoctorSubscription::class;
    public $searchModel = DoctorSubscriptionSearch::class;
}