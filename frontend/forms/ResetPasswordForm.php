<?php

namespace frontend\forms;

use common\entities\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }
}
