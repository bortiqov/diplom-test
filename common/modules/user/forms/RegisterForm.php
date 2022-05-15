<?php

namespace common\modules\user\forms;

use common\components\FormModel;
use common\modules\user\models\User;
use common\modules\user\models\UserEmailConfirmation;
use yii\base\Model;

/**
 * Register form
 */
class RegisterForm extends Model
{
    use FormModel;

    /**
     * @var
     */
    public $fullname;
    public $email;
    public $password;
    public $confirm_password;

    /**
     * @var
     */
    private $_confirmation;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'email', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class],
        ];
    }

    /**
     * @return $this|User|false
     * @throws \yii\base\Exception
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $user = $this->createUser();
        if ($user) {
            return $user;
        }

        return $this;
    }

    /**
     * @return array|User
     * @throws \yii\base\Exception
     */
    private function createUser()
    {
        $user = new User();
        $user->setAttributes([
            'first_name' => $this->fullname,
            'last_name' => $this->fullname,
            'email' => $this->email,
            'status' => User::STATUS_ACTIVE,
        ]);
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->setToken();
        if ($user->save()) {
            return $user;
        }
        \Yii::$app->response->setStatusCode(400);
        return $user->errors;

    }

}
