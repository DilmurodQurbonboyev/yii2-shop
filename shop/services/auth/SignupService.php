<?php

namespace shop\services\auth;

use shop\entities\User\User;
use shop\forms\auth\SignupForm;
use yii\mail\MailerInterface;
use DomainException;
use RuntimeException;

class SignupService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function signup(SignupForm $form)
    {
        if (User::find()->andWhere(['username' => $form->username])->exists()) {
            throw new DomainException('Username is already exists.');
        }
        if (User::find()->andWhere(['email' => $form->email])->exists()) {
            throw new DomainException('Email is already exists.');
        }

        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password,
        );



        $this->save($user);

        $sent = $this->mailer
            ->compose(
                ['html' => 'emailConfirmToken-html', 'text' => 'emailConfirmToken-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Signup confirm for ' . \Yii::$app->name)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Email sending error.');
        }
    }

    public function confirm($token): void
    {
        if (empty($token)) {
            throw new DomainException('Empty confirm token.');
        }

        $user = $this->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->save($user);
    }

    public function getByEmailConfirmToken(string $token): User
    {
        if (!$user = User::findOne(['email_confirm_token' => $token])) {
            throw new DomainException('User is not found');
        }
        return $user;
    }

    private function save(User $user): void
    {
        if (!$user->save()) {
            throw new RuntimeException('Saving error.');
        }
    }
}
