<?php

use yii\helpers\Url;
?>

<main class="user-page container">
    <div class="breadcrumbs">Главная <span>/</span> Личный кабинет</div>
    <div class="profile-layout">
        <aside class="account-sidebar">
            <div class="account-user"><span class="avatar small-avatar">АС</span><span><b>Анна Смирнова</b><small>Ваш
                        личный кинопрофиль</small></span></div>
            <nav class="account-nav"><a href="profile"><i class="fa-regular fa-user" aria-hidden="true"></i>
                    <span>Профиль</span></a><a href="votes"><i class="fa-solid fa-star" aria-hidden="true"></i> <span>Мои
                        голоса</span><small>2</small></a><a href="favorites"><i class="fa-regular fa-heart"
                        aria-hidden="true"></i> <span>Избранное</span></a><a href="watched"><i class="fa-solid fa-check"
                        aria-hidden="true"></i> <span>Просмотренные</span></a><a class="active" href="settings"><i
                        class="fa-solid fa-gear" aria-hidden="true"></i> <span>Настройки</span></a><button type="button"
                    class="logout-button"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                    <span>Выйти</span></button></nav>
        </aside>
        <section class="settings-content"><span class="eyebrow">ВАШ ВЕЧЕР НАЧИНАЕТСЯ ЗДЕСЬ</span>
            <h1>Настройки</h1>
            <p class="profile-intro">Управляйте уведомлениями и безопасностью аккаунта.</p>
            <section class="settings-card">
                <h2>Уведомления</h2><label class="setting-row"><span><b>Новости CineNight</b><small>Рассказывать о новых
                            фильмах и подборках</small></span><input type="checkbox" checked><i
                        class="setting-switch"></i></label><label class="setting-row"><span><b>Напоминания</b><small>Напоминать
                            о фильмах, которые вы выбрали</small></span><input type="checkbox" checked><i
                        class="setting-switch"></i></label>
            </section>
            <form class="settings-card password-form">
                <h2>Изменить пароль</h2><label>Текущий пароль<input type="password"
                        placeholder="Введите текущий пароль"></label><label>Новый пароль<input type="password"
                        placeholder="Придумайте новый пароль"></label><label>Повторите пароль<input type="password"
                        placeholder="Повторите новый пароль"></label>
                <div class="form-actions"><button class="button button-primary" type="submit">Сохранить изменения
                        <span>→</span></button></div>
            </form>
        </section>
    </div>
</main>

<div class="modal" id="logout-modal" role="dialog" aria-modal="true" aria-labelledby="logout-title">
    <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button>
        <h2 id="logout-title">Выйти из аккаунта?</h2>
        <p>Вы сможете вернуться в любое время.</p>
        <div class="logout-actions"><button class="button button-secondary modal-close-action">Остаться</button><a
                class="button button-primary" href="login">Выйти</a></div>
    </div>
</div>