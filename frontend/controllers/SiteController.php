<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use shop\entities\User\Network;
use shop\entities\User\User;

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

    //'UPDATE user SET status = 10 WHERE id = 3'
    //'SELECT * FROM user'
    public function actionIndex()
    {
        // $users = Yii::$app->db->createCommand('SELECT * FROM user_networks')->queryAll();
        // var_dump($users);
        // die;
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
