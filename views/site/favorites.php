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
                        голоса</span><small>2</small></a><a class="active" href="favorites"><i class="fa-regular fa-heart"
                        aria-hidden="true"></i> <span>Избранное</span></a><a href="watched"><i class="fa-solid fa-check"
                        aria-hidden="true"></i> <span>Просмотренные</span></a><a href="settings"><i
                        class="fa-solid fa-gear" aria-hidden="true"></i> <span>Настройки</span></a><button type="button"
                    class="logout-button"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                    <span>Выйти</span></button></nav>
        </aside>
        <section class="collection-content"><span class="eyebrow">ВАШ ВЕЧЕР НАЧИНАЕТСЯ ЗДЕСЬ</span>
            <h1>Избранное</h1>
            <p class="profile-intro">Фильмы, которые хочется сохранить для особенного вечера.</p>
            <div class="collection-toolbar"><b>4 фильма</b><a href="catalog">В каталог →</a></div>
            <div class="collection-grid">
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-francuzskij.jpeg") ?>" alt="Французский вестник"><span
                            class="hit-label">ХИТ</span><button class="save-button is-saved" aria-label="Удалить из избранного"><i
                                class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                    <div class="movie-info"><span class="movie-genre">КОМЕДИЯ</span>
                        <h3>Французский вестник</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star"
                                aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i
                                class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i>
                            <span>4.9</span> <small>(128)</small>
                        </div><button class="button button-primary review-button"
                            onclick="window.location.href='votes'" data-movie="Французский вестник">Оценить</button>
                    </div>
                </article>
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-daren.jpeg") ?>" alt="Свет далёких улиц"><span
                            class="hit-label teal">НОВИНКА</span><button class="save-button is-saved"
                            aria-label="Удалить из избранного"><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
                    </div>
                    <div class="movie-info"><span class="movie-genre">ДРАМА</span>
                        <h3>Свет далёких улиц</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star"
                                aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i
                                class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i>
                            <span>4.8</span> <small>(74)</small>
                        </div><button class="button button-primary review-button"
                            onclick="window.location.href='votes'" data-movie="Свет далёких улиц">Оценить</button>
                    </div>
                </article>
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-gorod.jpeg") ?>" alt="Город после полуночи"><span
                            class="hit-label purple">ВЫБОР РЕДАКЦИИ</span><button class="save-button is-saved"
                            aria-label="Удалить из избранного"><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
                    </div>
                    <div class="movie-info"><span class="movie-genre">ФАНТАСТИКА</span>
                        <h3>Город после полуночи</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star"
                                aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i
                                class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i>
                            <span>4.7</span> <small>(96)</small>
                        </div><button class="button button-primary review-button"
                            onclick="window.location.href='votes'" data-movie="Город после полуночи">Оценить</button>
                    </div>
                </article>
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-seans.jpeg") ?>" alt="Последний сеанс"><span
                            class="hit-label">ХИТ</span><button class="save-button is-saved" aria-label="Удалить из избранного"><i
                                class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                    <div class="movie-info"><span class="movie-genre">ТРИЛЛЕР</span>
                        <h3>Последний сеанс</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star"
                                aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i
                                class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i>
                            <span>4.6</span> <small>(41)</small>
                        </div><button class="button button-primary review-button"
                            onclick="window.location.href='votes'" data-movie="Последний сеанс">Оценить</button>
                    </div>
                </article>
            </div>
        </section>
    </div>
</main>

<div class="modal" id="review-modal" role="dialog" aria-modal="true" aria-labelledby="review-title">
    <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span
            class="eyebrow">ВАША ОЦЕНКА</span>
        <h2 id="review-title">Оценить фильм</h2>
        <p id="review-movie"></p>
        <div class="stars"><button><i class="fa-solid fa-star" aria-hidden="true"></i></button><button><i
                    class="fa-solid fa-star" aria-hidden="true"></i></button><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star" aria-hidden="true"></i></button></div>
        <button class="button button-primary modal-submit">Сохранить оценку</button>
    </div>
</div>
<div class="modal" id="logout-modal" role="dialog" aria-modal="true" aria-labelledby="logout-title">
    <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button>
        <h2 id="logout-title">Выйти из аккаунта?</h2>
        <p>Вы сможете вернуться в любое время.</p>
        <div class="logout-actions"><button class="button button-secondary modal-close-action">Остаться</button><a
                class="button button-primary" href="login">Выйти</a></div>
    </div>
</div>