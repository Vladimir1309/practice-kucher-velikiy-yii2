<?php

use yii\helpers\Html;

$identity = Yii::$app->user->identity;
$username = $identity ? $identity->username : 'Гость';
$initial = mb_strtoupper(mb_substr($username, 0, 1));
?>

<div class="account-user">
    <?php if ($identity && !empty($identity->avatar)): ?>
        <img src="<?= Yii::getAlias('@web') . Html::encode($identity->avatar) ?>" alt="Avatar" class="avatar small-avatar sidebar-avatar-img">
    <?php else: ?>
        <span class="avatar small-avatar avatar-initials"><?= Html::encode($initial) ?></span>
    <?php endif; ?>
    <span><b><?= Html::encode($username) ?></b><small>Ваш личный кинопрофиль</small></span>
</div>
