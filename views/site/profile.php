<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserMovie;

/* @var $user app\models\User */
$reviewCount = UserMovie::find()
    ->where(['user_id' => $user->id])
    ->andWhere(['is not', 'rating', null])
    ->count();
$initial = Html::encode(mb_strtoupper(mb_substr($user->username, 0, 1)));
?>

<main class="profile-page container">
    <div class="breadcrumbs">Главная <span>/</span> Личный кабинет</div>
    <div class="profile-layout">
        <aside class="account-sidebar" aria-label="Навигация профиля">
            <div class="account-user"><span class="avatar small-avatar"><?= $initial ?></span><span><b><?= Html::encode($user->username) ?></b><small>Зашли
                        недавно</small></span></div>
            <nav class="account-nav">
                <?= Html::a('<i class="fa-regular fa-user" aria-hidden="true"></i> <span>Профиль</span>', ['site/profile'], [
                    'class' => 'active',
                    'encode' => false,
                ]) ?>
                <?= Html::a('<i class="fa-solid fa-star" aria-hidden="true"></i> <span>Мои голоса</span><small>' . $reviewCount . '</small>', ['site/votes'], [
                    'encode' => false,
                ]) ?>
                <?= Html::a('<i class="fa-regular fa-heart" aria-hidden="true"></i> <span>Избранное</span>', ['site/favorites'], [
                    'encode' => false,
                ]) ?>
                <?= Html::a('<i class="fa-solid fa-check" aria-hidden="true"></i> <span>Просмотренные</span>', ['site/watched'], [
                    'encode' => false,
                ]) ?>
                <?= Html::a('<i class="fa-solid fa-gear" aria-hidden="true"></i> <span>Настройки</span>', ['site/settings'], [
                    'encode' => false,
                ]) ?>
                <button type="button" class="logout-button"><i class="fa-solid fa-arrow-right-from-bracket"
                        aria-hidden="true"></i> <span>Выйти</span></button>
            </nav>
        </aside>
        <section class="profile-content" aria-labelledby="profile-title">
            <span class="eyebrow">ВАШ ВЕЧЕР НАЧИНАЕТСЯ ЗДЕСЬ</span>
            <h1 id="profile-title">Профиль</h1>
            <p class="profile-intro">Ваши личные данные — всё в одном месте.</p>
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <p class="alert alert-success"><?= Html::encode(Yii::$app->session->getFlash('success')) ?></p>
            <?php endif; ?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'profile-form']]); ?>
                <div class="profile-identity"><span class="avatar"><?= $initial ?></span>
                    <div><b><?= Html::encode($user->username) ?></b><button type="button" class="change-avatar">Изменить фото</button><small>JPG или
                            PNG, до 5 МБ</small></div>
                </div>
                <div class="form-fields">
                    <?= $form->field($user, 'username')->textInput(['class' => 'form-control'])->label('Имя') ?>
                    <?= $form->field($user, 'last_name')->textInput(['class' => 'form-control'])->label('Фамилия') ?>
                    <?= $form->field($user, 'nickname')->textInput(['class' => 'form-control'])->label('Никнейм') ?>
                    <?= $form->field($user, 'birthdate')->input('date', ['class' => 'form-control'])->label('Дата рождения') ?>
                    <?= $form->field($user, 'email')->input('email', ['class' => 'form-control'])->label('Email') ?>
                    <?= $form->field($user, 'phone')->input('tel', ['class' => 'form-control'])->label('Телефон') ?>
                </div>
                <div class="form-actions"><button class="button button-primary" type="submit">Сохранить изменения
                        <span>→</span></button><small>Изменения будут сохранены в вашем профиле.</small></div>
            <?php ActiveForm::end(); ?>
        </section>
    </div>
</main>

<div class="modal" id="logout-modal" role="dialog" aria-modal="true" aria-labelledby="logout-title">
    <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span
            class="eyebrow">ЛИЧНЫЙ КАБИНЕТ</span>
        <h2 id="logout-title">Выйти из аккаунта?</h2>
        <p>Вы сможете вернуться в любое время.</p>
        <div class="logout-actions"><button class="button button-secondary modal-close-action"
                type="button">Остаться</button><?= Html::a('Выйти', ['site/logout'], [
                    'class' => 'button button-primary',
                    'data-method' => 'post',
                ]) ?></div>
    </div>
</div>