<?php

namespace frontend\controllers\auth;

use DomainException;
use shop\forms\auth\LoginForm;
use shop\services\auth\AuthService;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct($id, $module, AuthService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
            } catch (DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('login', [
            'model' => $form,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}