<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package tourline
 */

namespace common\modules\tag\services;


use common\modules\organization\models\Organization;
use common\modules\organization\repositories\OrganizationRepository;
use common\modules\organizations\dtos\RestaurantDTO;
use common\modules\tag\repositories\TagRepository;

class TagService
{

    private TagRepository $repository;

    function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return array|Organization
     */
    public function getById(int $id) {
        $model = $this->repository->getById($id);

        if(!$model){

            \Yii::$app->response->statusCode = 404;

            return [
                'code' => 200,
                'message' => 'Tag not found'
            ];
        }

        return $model;
    }

    /**
     * @return array|\common\modules\tag\models\Tag[]
     */
    public function getAll() {
        return $this->repository->getAll();
    }

}
