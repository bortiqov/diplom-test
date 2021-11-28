<?php

namespace common\modules\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\components\FormModel;

/**
 * This is the model class for table "user_email_confirmation".
 *
 * @property int $id
 * @property string $email
 * @property string $code
 * @property int $created_at
 * @property int $expires_at
 * @property int $status
 */
class UserEmailConfirmation extends \yii\db\ActiveRecord
{
    use FormModel;

    const STATUS_DELETED = 0;

    const STATUS_UNCONFIRMED = 1;

    const STATUS_SENT = 2;

    const STATUS_CONFIRMED = 3;

    const EXPIRATION_TIME = 7 * 24 * 3600;

    /**
     * @var
     */
    private $code_length = 12;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_email_confirmation';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['expires_at'],
                ],
                'value' => time() + self::EXPIRATION_TIME,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'user_id', 'code'], 'required'],
            ['email', 'email'],
            [['email', 'code'], 'string', 'max' => 255],
            [['expires_at'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_UNCONFIRMED],
//            ['status', 'in', 'range' => [self::STATUS_CONFIRMED, self::STATUS_UNCONFIRMED]],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @param int $length
     */
    public function generateCode()
    {
        $code = \Yii::$app->security->generateRandomString($this->code_length);
//        for ($i = 0; $i < $this->code_length; $i++) {
////            $code .= mt_rand(0,9);
//            $code .= $i + 1;
//        }

        $this->code = $code;
    }

    /**
     * @param $length
     */
    public function setCodeLength($length)
    {
        $this->code_length = $length;
    }

    /**
     * @param $email
     * @param $code
     * @return UserEmailConfirmation|null
     */
    public static function validateConfirmation($email, $code)
    {
//        return static::findOne(['email' => $email, 'code' => $code, 'status' => self::STATUS_UNCONFIRMED]);
        return static::findOne(['email' => $email, 'code' => $code]);
    }

    /**
     * @return int
     */
    public function setConfirmed()
    {
        return $this->updateAttributes([
            'status' => static::STATUS_CONFIRMED
        ]);
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->generateCode();

        return parent::beforeValidate();
    }

    /**
     * @return array|false
     */
    public function fields()
    {
        return [
            'id',
            'email'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'email',
            'code' => 'Code',
            'created_at' => 'Created At',
            'expires_at' => 'Expires At',
            'status' => 'Status',
        ];
    }
}
