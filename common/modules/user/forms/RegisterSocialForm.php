<?php

namespace common\modules\user\forms;

use Yii;
use yii\base\Model;
use common\components\FormModel;
use common\modules\user\models\User;
use common\modules\user\models\UserEmailConfirmation;

/**
 * RegisterSocial form
 */
class RegisterSocialForm extends Model
{
    use FormModel;

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $phone;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $password_confirm;

    /**
     * @var
     */
    public $first_name;

    /**
     * @var
     */
    public $last_name;

    /**
     * @var
     */
    public $image;

    /**
     * @var
     */
    public $country_id;

    /**
     * @var
     */
    public $region_id;

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
            [['email', 'first_name', 'last_name'], 'required'],
            [['email'], 'email'],
            [['email'], 'validateEmail'],
            [['phone', 'first_name', 'last_name'], 'string'],
            [['country_id', 'region_id'], 'integer'],
            ['phone', 'validatePhone'],
            [['password'], 'string', 'min' => 6],
            [['password'], 'compare', 'compareAttribute' => 'password_confirm'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateEmail($attribute, $params)
    {
        if(User::isEmailExists($this->email)){
            $this->addError("email", 'This email already exists');
        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePhone($attribute, $params)
    {
        if($this->phone && User::isPhoneExists($this->phone)){
            $this->addError("phone", 'This phone already exists');
        }
    }

    /**
     * @return User
     * @throws \yii\base\Exception
     */
    public function save()
    {
        if (!$this->validate()) {
            return  false;
        }

        $user = $this->createUser();

        return $user;
    }

    /**
     * @return User
     * @throws \yii\base\Exception
     */
    private function createUser()
    {
        $user = new User();
        $user->setAttributes([
            'email' => $this->email,
            'phone' => $this->phone,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'country_id' => $this->country_id,
            'region_id' => $this->region_id,
            'status' => User::STATUS_ACTIVE
        ]);
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->setToken();
        $user->save();

        $confirmation = new UserEmailConfirmation();
        $confirmation->setAttributes([
            'user_id' => $user->id,
            'email' => $user->email,
            'status' => UserEmailConfirmation::STATUS_CONFIRMED
        ]);
        $confirmation->save();

        return $user;
    }

}
