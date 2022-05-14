<?php

namespace api\models\form;

use common\modules\file\models\File;
use common\modules\user\models\User;

use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * Register form
 */
class UserUpdateForm extends Model
{
    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $id;
    public $first_name;
    public $last_name;
    public $username;
    public $middle_name;
    public $gender;
    public $face_type;
    public $birthday;
    public $address;
    public $phone;
    public $country_id;
    public $region_id;
    public $district_id;
    public $image;

    /**
     * @var
     */

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
            [['first_name', 'last_name','phone'], 'required'],
            [['email', 'first_name', 'last_name', 'address',], 'trim'],
            [['email', 'first_name', 'address', 'last_name','phone','middle_name','username'], 'string'],
            [['email'], 'email'],
            [['image'], 'safe'],
            [['email'],'validateEmail'],
            [['phone'],'validatePhone'],
            [['region_id', 'country_id','id','district_id','face_type','gender','birthday','id'], 'integer'],
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public function validateEmail($attribute, $params)
    {
        if (User::isEmailExists($attribute,$this->id)) {
            $this->addError($attribute, 'This email already exists');
        }
    }

    public function validatePhone($attribute, $params)
    {
        if (UserConfirmation::isPhoneExists($this->phone,$this->id)) {
            $this->addError($attribute, __('This phone already exists'));
        }
    }

    /**
     * @return array|User|false
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $user = $this->updateUser($this->id);
        return $user;
    }

    /**
     * @return array|User
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */


    public function update()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->updateUser($this->id);

        return $user;
    }

    private function updateUser($id)
    {
        $userProfile = UserInfo::find()->andWhere(['user_id' => $id])->one();
        $user = User::find()->andWhere(['id' => $id])->one();

        $user->setAttributes([
            'email' => $this->email,
            'username' => $this->username,
            'type' => User::TYPE_CUSTOMER,
            'branch_id' => $this->branch_id,
        ]);

        $image = UploadedFile::getInstanceByName('image');
        if ($image) {
            $file_id = File::saveFile($image);
            if ($file_id) {
                $user->image_id = $file_id;
            }
        }

        if ($this->first_name) {
            $user->setPassword($this->password);
            $user->generateAuthKey();
        }

        if (!$user->save()) {
            \Yii::$app->response->setStatusCode(400);
            return $user->errors;
        }

        $userProfile->setAttributes([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'user_id' => $user->id,
            'country_id' => $this->country_id,
            'region_id' => $this->region_id,
            'district_id' => $this->district_id,
            'face_type' => $this->face_type,
        ]);

        $confirmation = UserConfirmation::findOne(['user_id' => $user->id]);
        $confirmation->phone_number = $this->phone;
        if ($userProfile->save() && $confirmation->save()) {
            return $user;
        }
    }

}
