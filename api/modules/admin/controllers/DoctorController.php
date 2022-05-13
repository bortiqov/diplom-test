<?php

namespace api\modules\admin\controllers;

use backend\modules\admin\v1\forms\PostForm;
use common\models\Doctor;
use common\models\search\DoctorSearch;
use common\models\Service;
use common\models\ServiceSearch;
use common\modules\post\models\Post;
use common\modules\post\models\search\PostSearch;
use Yii;

class DoctorController extends \common\components\CrudController
{
    public $modelClass = Doctor::class;
    public $searchModel = DoctorSearch::class;


}