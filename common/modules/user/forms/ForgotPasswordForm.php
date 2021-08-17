<?php

namespace common\modules\user\forms;

use common\modules\user\models\UserEmailConfirmation;
use Yii;
use yii\base\Model;
use common\components\FormModel;
use common\modules\user\models\User;

/**
 * ForgotPasswordForm form
 */
class ForgotPasswordForm extends Model
{
    use FormModel;
    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'exist', 'targetClass' => User::class],
        ];
    }

    /**
     * @return $this|bool|UserEmailConfirmation
     */
    public function save()
    {
        if (!$this->validate()) {
            return  false;
        }

        /**
         * @var $user User
         */
        $user = User::findByEmail($this->email);

        $confirmation = $user->sendEmailForgotPasswordConfirmationCode();

        if($confirmation !== null){

            /**
             * @var UserEmailConfirmation $model
             */
            $model = $confirmation;
            $model->setResponseCode(101);
            $model->setResponseBody(true);

            return $model;
        }

        $this->setResponseCode(106);

        return $this;
    }
}
