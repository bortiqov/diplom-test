<?php

namespace api\modules\v1\controllers;

use api\models\form\LoginForm;
use common\components\ApiController;
use common\modules\user\forms\RegisterForm;
use common\modules\user\models\UserSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * User controller for the `v1` module;
 */

class UserController extends ApiController
{
    public $modelClass =\common\modules\user\models\User::class;
    public $searchModel = UserSearch::class;


    /**
     * @return array|RegisterForm|\common\modules\user\models\User
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRegister()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $form = new RegisterForm();
        $form->setAttributes($requestParams);
        $user = $form->save();

        if (!$user) {
            return $form;
        }

        return $user;
    }


    public function actionLogin()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }
        $form = new LoginForm();
        $form->setAttributes($requestParams);
        $user = $form->login();

        if (!$user) {
            return $form;
        }

        return $user;
    }


    /**
     * @param $service
     * @param $access_token
     * @return array|\yii\web\IdentityInterface|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \HttpRequestException
     * @throws \yii\base\Exception
     */
    public function actionSocial($service, $access_token)
    {
        $client = new Client();

        if ($access_token) {

            $oauth = [
                "facebook" => [
                    "profile_info" => "https://graph.facebook.com/me",
                    "fields" => "fields=id,email,first_name,last_name,picture.width(1920).height(1920){url}",
                ],
                "google" => [
                    "profile_info" => "https://www.googleapis.com/oauth2/v2/userinfo",
                    "fields" => "scope=id,email,picture,given_name,family_name",
                ],
            ];

            $response = $client->get($oauth[$service]["profile_info"] . "?access_token={$access_token}&{$oauth[$service]['fields']}");

            $body = (string)$response->getBody();
            $code = $response->getStatusCode();

            if ($code != 200) {
                return [
                    "status" => "error",
                    "message" => $body,
                    "code" => -10190
                ];
            }

            $responseData = [];

            $data = json_decode($body);
            switch ($service) {
                case "facebook":
                    $responseData = [
                        "id" => $data->id,
                        "first_name" => $data->first_name,
                        "last_name" => $data->last_name,
                        "email" => $data->email,
                        "avatar" => $data->picture->data->url,
                        "social" => "facebook"
                    ];
                    break;
                case "google":
                    $responseData = [
                        "id" => $data->id,
                        "first_name" => ($data->given_name) ? $data->given_name : 'Jon',
                        "last_name" => ($data->family_name) ? $data->family_name :  'Doe',
                        "email" => $data->email,
                        "avatar" => $data->picture . "?sz=192",
                        "social" => "google"
                    ];
                    break;
                default:
                    return [
                        "status" => "error",
                        "message" => "Soon",
                        "code" => -7777777,
                    ];
                    break;
            }

            $identity =  User::findByEmail($responseData['email']);


            if (!$identity) {

                $password = \Yii::$app->security->generateRandomString();

                $form = new RegisterSocialForm();
                $form->email = ($responseData['email']) ?: 'guest'. Yii::$app->security->generateRandomString(8). '@mail.com';
                $form->first_name = $responseData['first_name'];
                $form->last_name = $responseData['last_name'];
                $form->password = $password;
                $form->password_confirm = $password;
                $identity = $form->save();
            }


            \Yii::$app->user->login($identity, 3600 * 24 * 30);

            return \Yii::$app->user->identity;
        }

        throw new \HttpRequestException("Param access_token is not sent");
    }

    /**
     * @return ForgotPasswordForm|array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionForgotPassword()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $form = new ForgotPasswordForm();
        $form->setAttributes($requestParams);
        $user = $form->sendEmail();

        if (!$user) {
            return $form;
        }

        return [
            'code' => 1,
            'message' => Yii::t('main', 'We are sent message your email')
        ];
    }

    public function actionChangePassword()
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $form = new ResetPasswordForm($requestParams['token']);
        $form->setAttributes($requestParams);
        $user = $form->resetPassword();

        if (!$user) {
            return $form;
        }

        return $user;
    }

    public function actionConfirmEmail($hash)
    {
        $confirm = UserEmailConfirmation::findOne(['code' => $hash]);
        $form = new ConfirmEmailForm();
        $form->email = $confirm->email;
        $form->code = $hash;

        if ($user = $form->save()){
            $confirm->updateAttributes(['status' => UserEmailConfirmation::STATUS_CONFIRMED]);
            \Yii::$app->user->login($user, 3600 * 24 * 30);

            return $user;
        }

        if (!$user) {
            return $form;
        }

    }

    public function actionConfirmForgotEmail($hash)
    {
        $confirm = UserEmailConfirmation::findOne(['code' => $hash]);

        $confirm = UserEmailConfirmation::validateConfirmation($confirm->email, $hash);

        $user = User::findByEmail($confirm->email);
        if ($user){
            $confirm->updateAttributes(['status' => UserEmailConfirmation::STATUS_CONFIRMED]);
            \Yii::$app->user->login($user, 3600 * 24 * 30);

            return $user;
        }

        throw new NotFoundHttpException('User not found');
    }

}
