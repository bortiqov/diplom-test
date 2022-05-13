<?php

namespace common\modules\user\models;

use common\models\Image;
use common\modules\country\models\Country;
use common\modules\file\models\File;
use common\modules\organization\models\Organization;
use common\modules\organization\models\OrganizationReview;
use common\modules\organization\models\UserOrganization;
use common\modules\product\models\Product;
use common\modules\product\models\ProductBookmark;
use common\modules\product\models\ProductReview;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property string $website
 * @property string $contact_number
 * @property string $company_name
 * @property string $job_title
 * @property integer $status
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $affiliate_key
 * @property string $password write-only password
 * @property string $password_reset_token [varchar(255)]
 * @property string $verification_token [varchar(255)]
 * @property int $type [smallint]
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     *
     */
    const STATUS_DELETED = 0;

    /**
     *
     */
    const STATUS_INACTIVE = 9;

    /**
     *
     */
    const STATUS_ACTIVE = 10;

    const ROLE_EDITOR = 1;

    const ROLE_MODERATOR = 'moderator';

    const ROLE_BLOGGER = 'blogger';

    const ROLE_ADMIN = 'admin';

    const TYPE_ADMIN = 1;

    const TYPE_VISITOR = 2;

    const TYPE_ORGANISATOR = 3;

    /**
     * @var
     */
    public $organizationIds;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $password_confirm;

    /**
     * @var $role
     */
    public $role;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'email'],
            [['first_name', 'last_name', 'email', 'phone', 'role'], 'string'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            [['organizationIds'], 'safe'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'phone' => 'Phone',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'status' => 'Статус',
            'type' => 'Тип',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by phone
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     *
     */
    public static function isEmailExists($email, $id = null)
    {
        return static::find()->where(['email' => $email])->andWhere(['<>', 'id', $id])->exists();
    }

    /**
     *
     */
    public static function isPhoneExists($phone)
    {
        return static::find()->where(['phone' => $phone])->exists();
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public static function generateToken()
    {
        return \Yii::$app->security->generateRandomString(64);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function setToken()
    {
        $this->token = self::generateToken();
    }

    /**
     * @return array|UserEmailConfirmation|ActiveRecord|null
     */
    public function sendEmailConfirmationCode()
    {
        $confirmation = UserEmailConfirmation::find()
            ->where(['email' => $this->email, 'status' => UserEmailConfirmation::STATUS_UNCONFIRMED])
            ->andWhere(['>', 'expires_at', time()])
            ->one();

        if (!($confirmation instanceof UserEmailConfirmation)) {

            UserEmailConfirmation::updateAll(['status' => UserEmailConfirmation::STATUS_DELETED], ['email' => $this->email]);

            $confirmation = new UserEmailConfirmation();
            $confirmation->setCodeLength(6);
            $confirmation->setAttributes([
                'user_id' => $this->id,
                'email' => $this->email
            ]);


            if ($confirmation->save()) {
                Yii::$app->mailer->compose()
                    ->setFrom(getenv('MAILER_USERNAME'))
                    ->setTo($this->email)
                    ->setSubject(__('Email Confirmation Subject'))
                    ->setHtmlBody(__("You successfully registred on Holiday please confirm your email. Link: ") . '<a href="https://dev.holiday.uz/' . \Yii::$app->language . '/user/update?hash=' . $confirmation->code . '">Confirm email</a>')
//                    ->setHtmlBody(__("You successfully registred on Holiday please confirm your email. Link: ") . '<a href="http://localhost:8080/' . \Yii::$app->language . '/user/update?hash=' . $confirmation->code . '">Confirm email</a>')
                    ->send();
                $confirmation->updateAttributes(['status' => UserEmailConfirmation::STATUS_SENT]);
            }
        }

        return $confirmation;
    }

    /**
     * @return array|UserEmailConfirmation|ActiveRecord|null
     */
    public function sendEmailForgotPasswordConfirmationCode()
    {
        $confirmation = UserEmailConfirmation::find()
            ->where(['email' => $this->email, 'status' => UserEmailConfirmation::STATUS_CONFIRMED])
            ->andWhere(['>', 'expires_at', time()])
            ->one();


        if (($confirmation instanceof UserEmailConfirmation)) {
            Yii::$app->mailer->compose()
                ->setFrom(getenv('MAILER_USERNAME'))
                ->setTo($this->email)
                ->setSubject('Forgot password')
                ->setHtmlBody('Forgot password code: <a href="https://dev.holiday.uz/' . \Yii::$app->language . '/user/forget_password?hash=' . $confirmation->code . '">Confirm email</a>')
                ->send();
            $confirmation->updateAttributes([
                'status' => UserEmailConfirmation::STATUS_SENT,
                'expires_at' => time() + UserEmailConfirmation::EXPIRATION_TIME
            ]);
        }

        return $confirmation;
    }

    /**
     * @return int
     */
    public function setActivated()
    {
        return $this->updateAttributes([
            'status' => static::STATUS_ACTIVE
        ]);
    }

    /**
     * @return int
     * @throws \yii\base\Exception
     */
    public function updateToken()
    {
        return $this->updateAttributes([
            'token' => self::generateToken()
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }

    public function getBookmarks()
    {
        return $this->hasMany(UserBookmark::class, ['user_id' => 'id']);
    }

    public function getUserBookmarks()
    {
        return $this->hasMany(Organization::class, ['id' => 'organization_id'])
            ->via('bookmarks');
    }

    public function getProductBookmarks()
    {
        return $this->hasMany(ProductBookmark::class, ['user_id' => 'id']);
    }

    public function getUserProductBookmarks()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])
            ->via('productBookmarks');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageThumbs()
    {
        $image = $this->image;

        if (!$image) {
            return null;
        }

        return @$image->getImageThumbs();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOrganizations()
    {
        return $this->hasMany(UserOrganization::class, ['user_id' => 'id']);
    }

    public static function getUserRole($user_id)
    {
        return ArrayHelper::map(Yii::$app->authManager->getRolesByUser($user_id), 'name', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organization::class, ['id' => 'organization_id'])->via('userOrganizations');
    }

    /**
     * @param bool $insert
     *
     * @return bool
     * @throws \yii\base\Exception
     */
//    public function beforeSave($insert)
//    {
//        if (($this->password && $this->password_confirm) || $this->isNewRecord)
//            $this->setPassword($this->password_confirm);
//
//        $this->auth_key = $this->auth_key ?: Yii::$app->security->generateRandomString();
//
//        return parent::beforeSave($insert);
//    }

    public static function findByEAuth($service)
    {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        } else {
            $hasAlready = static::findOne(['email' => $service->getAttribute('email')]);
            if (!isset($hasAlready)) {
                $newUser = new User();
                $newUser->first_name = $service->getAttribute('first_name');
                $newUser->last_name = $service->getAttribute('last_name');
                $newUser->email = $service->getAttribute('email');
                $newUser->interested_area = 'Expo';
                $newUser->setPassword(md5('qw1234er5678ty'));
                $newUser->status = self::STATUS_ACTIVE;

//                if($newUser->save())
                $newUser->save();
                return $newUser;
            }
            return $hasAlready;
        }
    }

    public function getAvatar()
    {
        $avatar = $this->hasOne(File::class, ['id' => 'image_id']);

        if ($avatar->count()) return $avatar;
        return File::findOne(\Yii::$app->params['default_avatar_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    public function getReviews()
    {
        return $this->hasMany(OrganizationReview::class, ['user_id' => 'id']);
    }

    public static function getDropdownList()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'email');
    }

    public function getAverageRate()
    {
        return number_format($this->getReviews()
            ->select('(avg(score_quality)+avg(score_service)+avg(score_location)+avg(score_price)) / 4 as avg_score')
            ->one()
            ->avg_score, 1);
    }

    public function getProductReviews()
    {
        return $this->hasMany(ProductReview::class, ['user_id' => 'id']);
    }

    public function getProductAverageRate()
    {
        return number_format($this->getProductReviews()
            ->select('(avg(score_quality)+avg(score_service)+avg(score_location)+avg(score_price)) / 4 as avg_score')
            ->one()
            ->avg_score, 1);
    }

    /**
     * @return array|false
     */
    public function fields()
    {
        return [
            "id",
            "email",
            "token",
            "first_name",
            'phone',
            "last_name",
            "image" => function ($model) {
                $image = $model->avatar;

                if (!$image) {
                    return null;
                }

                return @$image->getImageSrc('small');
            },
            "created_at",
            "updated_at",
            "status",
        ];
    }

    public function extraFields()
    {
        return [

        ];
    }

    public function getProfileLink()
    {
        return "";
    }

    public function getPrettyName()
    {
        return $this->email;
    }

    public static function getRoles()
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
    }

    public function getUnseenMessagesCount($exhibition_id)
    {
        return PrivateChat::find()
            ->where(['exhibition_id' => $exhibition_id, 'seen' => 0, 'author_type' => PrivateChat::AUTHOR_TYPE_ORGANIZATION, 'to' => \Yii::$app->user->identity->getId()])
            ->count();
    }
}
