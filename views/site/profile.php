<?php

use yii\helpers\Html;

/* @var $user app\models\User */
$username = Html::encode($user->username);
$email = Html::encode($user->email);
$phone = Html::encode($user->phone ?: 'Не указан');
$initial = Html::encode(mb_strtoupper(mb_substr($user->username, 0, 1)));
?>

<main class="profile-page container">
    <div class="breadcrumbs">Главная <span>/</span> Личный кабинет</div>
    <div class="profile-layout">
        <aside class="account-sidebar" aria-label="Навигация профиля">
            <div class="account-user"><span class="avatar small-avatar"><?= $initial ?></span><span><b><?= $username ?></b><small>Зашли
                        недавно</small></span></div>
            <nav class="account-nav">
                <?= Html::a('<i class="fa-regular fa-user" aria-hidden="true"></i> <span>Профиль</span>', ['site/profile'], [
                    'class' => 'active',
                    'encode' => false,
                ]) ?>
                <?= Html::a('<i class="fa-solid fa-star" aria-hidden="true"></i> <span>Мои голоса</span><small>2</small>', ['site/votes'], [
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
            <form class="profile-form">
                <div class="profile-identity"><span class="avatar"><?= $initial ?></span>
                    <div><b><?= $username ?></b><button type="button" class="change-avatar">Изменить фото</button><small>JPG или
                            PNG, до 5 МБ</small></div>
                </div>
                <div class="form-fields">
                    <label class="form-group">Имя<span class="form-hint"></span><input type="text" value="<?= $username ?>"></label>
                    <label class="form-group">Фамилия<span class="form-hint"></span><input type="text" value=""></label>
                    <label class="form-group">Никнейм<span class="form-hint">Отображается в ваших отзывах</span><input
                            type="text" value="<?= Html::encode($user->nickname ?: $user->username) ?>"></label>
                    <label class="form-group">Дата рождения<span class="form-hint"></span><input type="text"
                            placeholder="ДД.ММ.ГГГГ"></label>
                    <label class="form-group">Email<span class="form-hint"></span><input type="email"
                            value="<?= $email ?>"></label>
                    <label class="form-group">Телефон<span class="form-hint"></span><input type="tel"
                            value="<?= $phone === 'Не указан' ? '' : $phone ?>" placeholder="<?= $phone ?>"></label>
                </div>
                <div class="form-actions"><button class="button button-primary" type="submit">Сохранить изменения
                        <span>→</span></button><small>Изменения будут сохранены в вашем профиле.</small></div>
            </form>
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