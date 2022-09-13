<?php

namespace shop\repositories\User;

use shop\entities\User\User;
use shop\repositories\NotFoundException;

class UserRepository
{
    public function findByUsernameOrEmail($value)
    {
        return User::find()->andWhere([
            'or',
            ['username' => $value],
            ['email' => $value]
        ])->one();
    }

    public function get($id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function findByNetworkIdentity($network, $identity)
    {
        return User::find()->joinWith('networks n')->andWhere([
            'n.network' => $network,
            'n.identity' => $identity
        ])->one();
    }

    public function getByEmailConfirmToken($token)
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }

    public function getByEmail($email)
    {
        return $this->getBy(['email' => $email]);
    }

    public function getByPasswordResetToken($token)
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function existsByPasswordResetToken(string $token)
    {
        return (bool)User::findByPasswordResetToken($token);
    }

    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error');
        }
    }

    private function getBy(array $condition)
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found.');
        }
        return $user;
    }
}
