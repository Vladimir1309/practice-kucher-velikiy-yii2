<?php

use yii\helpers\Url;
?>

<main class="votes-page container">
    <div class="breadcrumbs">Главная <span>/</span> Личный кабинет</div>
    <div class="profile-layout">
        <aside class="account-sidebar" aria-label="Навигация профиля">
            <?= $this->render('_account_user') ?>
            <nav class="account-nav">
                <a href="profile"><i class="fa-regular fa-user" aria-hidden="true"></i> <span>Профиль</span></a>
                <a class="active" href="votes"><i class="fa-solid fa-star" aria-hidden="true"></i> <span>Мои
                        голоса</span><small>2</small></a>
                <a href="favorites"><i class="fa-regular fa-heart" aria-hidden="true"></i> <span>Избранное</span></a>
                <a href="watched"><i class="fa-solid fa-check" aria-hidden="true"></i> <span>Просмотренные</span></a>
                <a href="settings"><i class="fa-solid fa-gear" aria-hidden="true"></i> <span>Настройки</span></a>
                <button type="button" class="logout-button"><i class="fa-solid fa-arrow-right-from-bracket"
                        aria-hidden="true"></i> <span>Выйти</span></button>
            </nav>
        </aside>
        <section class="votes-content" aria-labelledby="votes-title">
            <span class="eyebrow">ВАШ ВЕЧЕР НАЧИНАЕТСЯ ЗДЕСЬ</span>
            <h1 id="votes-title">Мои голоса <sup>2</sup></h1>
            <p class="profile-intro">Ваши любимые истории — и планы на следующий киновечер.</p>
            <div class="reviewed-movies">
                <article class="reviewed-card" data-movie="Французский вестник" tabindex="0">
                    <img src="<?= Url::to("@web/images/catalog-francuzskij.jpeg") ?>" alt="Французский вестник">
                    <div><span class="movie-genre">КОМЕДИЯ</span>
                        <h2>Французский вестник</h2>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star"
                                aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i
                                class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i>
                            <span>4.9</span> <small>(128)</small>
                        </div><b class="voted-label">◉ Голос учтён</b>
                    </div>
                </article>
                <article class="reviewed-card" data-movie="Свет далёких улиц" tabindex="0">
                    <img src="<?= Url::to("@web/images/catalog-daren.jpeg") ?>" alt="Свет далёких улиц">
                    <div><span class="movie-genre">ДРАМА</span>
                        <h2>Свет далёких улиц</h2>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star"
                                aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i
                                class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i>
                            <span>4.8</span> <small>(74)</small>
                        </div><b class="voted-label">◉ Голос учтён</b>
                    </div>
                </article>
            </div>
            <form class="vote-form">
                <div class="vote-form-heading"><span class="form-icon"><i class="fa-solid fa-star"
                            aria-hidden="true"></i></span>
                    <div>
                        <h2>Оценить фильм</h2>
                        <p>Выберите фильм, оцените его и добавьте комментарий. Мы сохраним ваш голос.</p>
                    </div>
                </div>
                <div class="vote-fields">
                    <label>Фильм <em>*</em><select>
                            <option>Город после полуночи</option>
                            <option>Последний сеанс</option>
                            <option>Между нами ночь</option>
                        </select></label>
                    <fieldset>
                        <legend>Ваша оценка <em>*</em></legend>
                        <div class="vote-stars" role="group" aria-label="Выберите рейтинг"><button type="button"
                                data-rating="1"><i class="fa-solid fa-star" aria-hidden="true"></i></button><button type="button"
                                data-rating="2"><i class="fa-solid fa-star" aria-hidden="true"></i></button><button type="button"
                                data-rating="3"><i class="fa-solid fa-star" aria-hidden="true"></i></button><button type="button"
                                data-rating="4"><i class="fa-solid fa-star" aria-hidden="true"></i></button><button type="button"
                                data-rating="5"><i class="fa-solid fa-star" aria-hidden="true"></i></button></div>
                    </fieldset>
                    <label class="comment-label">Комментарий <span>Необязательно</span><textarea rows="4"
                            placeholder="Хочется атмосферного кино для пятничного вечера. Соберёмся вместе?"></textarea></label>
                </div>
                <small class="required-note"><em>*</em> Обязательные поля</small>
                <div class="form-actions"><button class="button button-primary" type="submit">Сохранить голос
                        <span>→</span></button><small>Ваш выбор поможет решить, что отсмотрим вместе.</small></div>
            </form>
        </section>
    </div>
</main>

<div class="modal" id="review-modal" role="dialog" aria-modal="true" aria-labelledby="review-title">
    <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span
            class="eyebrow">ВАША ОЦЕНКА</span>
        <h2 id="review-title">Оценить фильм</h2>
        <p id="review-movie"></p>
        <div class="stars" role="group" aria-label="Выберите рейтинг"><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star" aria-hidden="true"></i></button></div>
        <button class="button button-primary modal-submit">Сохранить оценку</button>
    </div>
</div>
<div class="modal" id="logout-modal" role="dialog" aria-modal="true" aria-labelledby="logout-title">
    <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span
            class="eyebrow">ЛИЧНЫЙ КАБИНЕТ</span>
        <h2 id="logout-title">Выйти из аккаунта?</h2>
        <p>Вы сможете вернуться в любое время.</p>
        <div class="logout-actions"><button class="button button-secondary modal-close-action"
                type="button">Остаться</button><a class="button button-primary" href="login">Выйти</a></div>
    </div>
</div>