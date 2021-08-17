<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package tourline
 */

namespace common\modules\language\services;


use common\modules\language\repositories\LanguageRepository;

class LanguageService
{

    private LanguageRepository $repository;

    function __construct(LanguageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getById(int $id) {
        return $this->repository->getById($id);
    }

    public function getAll() {
        return $this->repository->getAll();
    }


}