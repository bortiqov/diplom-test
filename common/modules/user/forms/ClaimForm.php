<?php

namespace common\modules\user\forms;

use common\modules\user\models\ClaimRequest;
use Yii;
use yii\base\Model;
use common\components\FormModel;
use common\modules\user\models\User;
use common\modules\user\models\UserEmailConfirmation;

/**
 * Login form
 */
class ClaimForm extends Model
{
    use FormModel;

    /**
     * @var
     */
    public $organization_id;

    /**
     * @var
     */
    public $message;

    /**
     * @var int|string
     */
    public $user_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_id', 'message'], 'required'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->user_id = Yii::$app->user->id;

        if(\Yii::$app->user->identity->status === User::STATUS_DELETED){
            $this->setResponseCode(103);
            $this->addError("login", "User was deleted.");
        }

        $model = new ClaimRequest();

        $model->setAttributes($this->attributes);

        $model->save();

        // Claim requestga user_id, organization_id, message ni tiqib, statusini under_moderate qilib qo'yasiz

        return $this;
    }

}
