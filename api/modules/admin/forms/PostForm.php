<?php

namespace backend\modules\admin\v1\forms;

use common\modules\file\models\File;
use common\modules\post\models\Post;
use common\modules\post\models\PostImg;
use yii\base\Model;
use yii\web\NotFoundHttpException;

class PostForm extends Model
{

    public $title;
    public $id;

    public $description;

    public $type;

    public $published_at;

    public $top;
    public $status;

    public $fileIds;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'categoryIds','teamIds','personIds','tagIds','clubIds','fileIds'], 'safe'],
            [['title', 'description', 'type', 'published_at'], 'required'],
            [['published_at', 'top', 'status','id'], 'integer'],
        ];
    }


    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $post = $this->createPost();

        if ($post) {
            return $post;
        }

        return false;
    }

    public function update()
    {
        if (!$this->validate()) {
            return false;
        }

        $post = $this->updatePost($this->id);

        if ($post) {
            return $post;
        }

        return false;
    }

    /**
     * @return array|Post
     */
    private function createPost()
    {
        $post = new Post([
            'title' => $this->title,
            'description' => $this->description,
            'published_at' => $this->published_at,
            'type' => $this->type,
            'top' => $this->top,
            'status' => $this->status,
        ]);

        if (!$post->save()) {
            \Yii::$app->response->setStatusCode(400);
            return $post->errors;
        }

        if (is_array($this->fileIds)) {
            foreach ($this->fileIds as $fileId) {
                $file = File::findOne($fileId);
                if ($file) {
                    $post->link('files', $file);
                }
            }
        }
        return $post;

    }

    private function updatePost($id)
    {
        $post = Post::findOne($id);
        if (!$post) {
            throw new NotFoundHttpException("Model not found");
        }

        $post->setAttributes([
            'title' => $this->title,
            'description' => $this->description,
            'published_at' => $this->published_at,
            'type' => $this->type,
            'top' => $this->top,
            'status' => $this->status,
        ]);

        if (!$post->save()) {
            \Yii::$app->response->setStatusCode(400);
            return $post->errors;
        }

        if (is_array($this->fileIds)) {
            PostImg::deleteAll(['post_id' => $post->id]);

            foreach ($this->fileIds as $fileId) {
                $file = File::findOne($fileId);
                if ($file) {
                    $post->link('files', $file);
                }
            }
        }
        return $post;

    }

}