<?php

namespace frontend\controllers;

use DomainException;
use Yii;
use yii\web\Controller;
use shop\forms\LoginForm;
use shop\forms\SignupForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use shop\forms\VerifyEmailForm;
use shop\forms\ResetPasswordForm;
use shop\services\auth\AuthService;
use yii\web\BadRequestHttpException;
use shop\services\auth\SignupService;
use yii\base\InvalidArgumentException;
use shop\forms\PasswordResetRequestForm;
use shop\forms\ResendVerificationEmailForm;
use shop\services\auth\PasswordResetService;

class SiteController extends Controller
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [

                 'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }


    /*    public function actionVerifyEmail($token)
        {
            try {
                $model = new VerifyEmailForm($token);
            } catch (InvalidArgumentException $e) {
                throw new BadRequestHttpException($e->getMessage());
            }
            if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
            return $this->goHome();
        }*/

    /*public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }*/
}
