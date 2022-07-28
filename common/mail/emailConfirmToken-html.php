<?php

use yii\helpers\Html;

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $user->email_confirm_token]);

?>

<div class="password-reset">
    <p>Hello <?php Html::encode($user->username) ?></p>
    <p>Follow the link below to confirm your email:</p>
    <p><?php Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>
