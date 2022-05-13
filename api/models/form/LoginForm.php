<?php

namespace api\models\form;

use Yii;
use yii\base\Model;
use common\modules\user\models\User;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @return User|false|null
     * @throws ForbiddenHttpException
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user) {
                Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
                return $user;
            }
            throw new NotFoundHttpException('User not found');
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
