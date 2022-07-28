<?php

namespace common\bootstrap;

//use services\auth\PasswordResetService;
//use services\contact\ContactService;
use shop\services\auth\PasswordResetService;
use shop\services\contact\ContactService;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(PasswordResetService::class);
        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(ContactService::class, [], [
            [
                $app->params['adminEmail'],
            ]
        ]);
    }
}