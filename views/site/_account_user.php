<?php

use yii\helpers\Html;

$identity = Yii::$app->user->identity;
$username = $identity ? $identity->username : 'Гость';
$initial = mb_strtoupper(mb_substr($username, 0, 1));
?>

<div class="account-user">
    <span class="avatar small-avatar"><?= Html::encode($initial) ?></span>
    <span><b><?= Html::encode($username) ?></b><small>Ваш личный кинопрофиль</small></span>
</div>
