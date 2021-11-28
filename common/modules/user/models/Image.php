<?php

namespace common\modules\user\models;

use jakharbek\filemanager\helpers\FileManagerHelper;

/**
 * Class Image
 * @package common\modules\user\models
 */
class Image extends \jakharbek\filemanager\models\Files
{
    /**
     * @return array|false
     */
    public function fields()
    {
        $fields = [];
        if($this->getIsImage()){
            $imageSizes = $this->getImageThumbs();
            foreach ($imageSizes as $key => $imageSize) {
                $fields[$key] = function ($model) use ($imageSize){
                    return $imageSize;
                };
            }
        }
        return $fields;
    }

    /**
     * @return mixed
     */
    public function getImageThumbs()
    {
        $thumbsImages = FileManagerHelper::getThumbsImage();
        foreach ($thumbsImages as &$thumbsImage) {
            $slug = $thumbsImage['slug'];
            $thumbsImage = getenv("STATIC_URL") . $this->folder . $this->file . "_" . $slug . "." . $this->ext;
        }
        return $thumbsImages;
    }
}
