<?php

use yii\helpers\Url;
?>

<main>
    <section class="hero container">
        <div class="hero-copy">
            <span class="eyebrow">ПОДБОРКА НЕДЕЛИ</span>
            <h1>Кино, которое<br>хочется смотреть<br>вместе</h1>
            <p>Тёплые истории, яркое приключение и немного магии — мы уже собрали идеальный вечер для вас.</p>
            <div class="hero-actions">
                <button class="button button-primary" type="button" id="hero-lucky-button">Мне повезёт <span>→</span></button>
                <a class="button button-secondary" href="catalog">Тайное кино</a>
            </div>
            <div class="stats" aria-label="Статистика сервиса">
                <div><strong>24</strong><span>фильма</span></div>
                <div><strong>4.9</strong><span>средний рейтинг</span></div>
                <div><strong>6 ч</strong><span>уютного кино</span></div>
            </div>
        </div>
        <div class="hero-poster">
            <img src="<?= Url::to("@web/images/hero-cine-night.jpeg") ?>" alt="Кадр из фильма с девушкой в неоновом свете">
            <div class="poster-caption"><span class="mini-mark">C</span><span>Добро пожаловать<br><small>в CineNight</small></span></div>
        </div>
    </section>

    <section class="categories container" aria-labelledby="categories-title">
        <div class="section-heading">
            <div><span class="eyebrow">ВЫБИРАЙТЕ НАСТРОЕНИЕ</span>
                <h2 id="categories-title">Категории</h2>
                <p>От лёгких комедий до фантастических миров.</p>
            </div>
            <a href="catalog" class="text-link">Все категории <span>→</span></a>
        </div>
        <div class="genre-grid">
            <a class="genre-chip" href="catalog"><span class="genre-icon comedy">✦</span><span><b>Комедии</b><small>48 фильмов</small></span><span>›</span></a>
            <a class="genre-chip" href="catalog"><span class="genre-icon drama">✦</span><span><b>Драмы</b><small>32 фильма</small></span><span>›</span></a>
            <a class="genre-chip" href="catalog"><span class="genre-icon horror">☾</span><span><b>Ужасы</b><small>27 фильмов</small></span><span>›</span></a>
            <a class="genre-chip" href="catalog"><span class="genre-icon fantasy">✺</span><span><b>Фантастика</b><small>54 фильма</small></span><span>›</span></a>
        </div>
    </section>

    <section class="hits container" id="hits" aria-labelledby="hits-title">
        <div class="section-heading">
            <div><span class="eyebrow">ГОРЯЧОЕ СЕГОДНЯ</span>
                <h2 id="hits-title">Хиты вечера</h2>
                <p>Самые любимые фильмы нашего сообщества.</p>
            </div>
            <a class="button button-light" href="favorites">В каталог</a>
        </div>
        <div class="movie-grid">
            <article class="movie-card" data-genre="Драмы">
                <div class="movie-image"><img src="<?= Url::to("@web/images/movie-francuzskij-dispetcher.jpeg") ?>" alt="Французский диспетчер"><span class="hit-label">ХИТ</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                <div class="movie-info"><span class="movie-genre">ДРАМА</span>
                    <h3>Французский диспетчер</h3>
                    <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.8</span> <small>(128)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="Французский диспетчер">Оценить</button>
                </div>
            </article>
            <article class="movie-card" data-genre="Драмы">
                <div class="movie-image"><img src="<?= Url::to("@web/images/movie-daren-darok.jpeg") ?>" alt="Дарен дарок улицы"><span class="hit-label teal">НОВИНКА</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                <div class="movie-info"><span class="movie-genre">ДРАМА</span>
                    <h3>Дарен дарок улицы</h3>
                    <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.7</span> <small>(84)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="Дарен дарок улицы">Оценить</button>
                </div>
            </article>
            <article class="movie-card" data-genre="Фантастика">
                <div class="movie-image"><img src="<?= Url::to("@web/images/movie-gorod-posle-polunochi.jpeg") ?>" alt="Город после полуночи"><span class="hit-label purple">ВЫБОР РЕДАКЦИИ</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                <div class="movie-info"><span class="movie-genre">ФАНТАСТИКА</span>
                    <h3>Город после полуночи</h3>
                    <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.7</span> <small>(96)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="Город после полуночи">Оценить</button>
                </div>
            </article>
            <article class="movie-card" data-genre="Триллер">
                <div class="movie-image"><img src="<?= Url::to("@web/images/movie-poslednij-seans.jpeg") ?>" alt="Последний сеанс"><span class="hit-label">ХИТ</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                <div class="movie-info"><span class="movie-genre">ТРИЛЛЕР</span>
                    <h3>Последний сеанс</h3>
                    <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.6</span> <small>(41)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="Последний сеанс">Оценить</button>
                </div>
            </article>
        </div>
    </section>

    <section class="lucky container">
        <div><span class="eyebrow teal-text">СОБЕРИТЕ СВОЙ ВЕЧЕР</span>
            <h2>Не знаете, что посмотреть?</h2>
            <p>Доверьтесь случаю — мы выберем фильм для вас!</p><button class="button button-pink" id="lucky-button">Мне повезёт <span>→</span></button>
        </div>
        <div class="bubbles" aria-hidden="true"><span>КОМЕДИИ</span><span>ДРАМА</span><span>САЙ-ФАЙ</span></div>
    </section>
</main>