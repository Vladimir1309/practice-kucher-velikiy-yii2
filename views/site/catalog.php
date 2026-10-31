<?php

use yii\helpers\Url;
?>

<main class="catalog-page container">
    <div class="breadcrumbs">Главная <span>/</span> Каталог</div>
    <div class="catalog-heading">
        <div><span class="eyebrow">ВЫБЕРИТЕ НАСТРОЕНИЕ</span>
            <h1>Каталог фильмов</h1>
            <p>Найдите историю под своё настроение — и голосуйте за любимую.</p>
        </div><span class="catalog-note">256 фильмов для ваших вечеров</span>
    </div>
    <button class="filter-toggle" type="button" aria-expanded="false" aria-controls="catalog-filters">Фильтры <span>☷</span></button>
    <div class="catalog-layout">
        <aside class="catalog-filters" id="catalog-filters" aria-label="Фильтры каталога">
            <div class="filters-title"><b>Фильтры</b><button class="filter-close" type="button" aria-label="Закрыть фильтры">×</button><span>☷</span></div>
            <fieldset>
                <legend>Жанры</legend><label><input type="checkbox" checked> Комедии <small>48</small></label><label><input type="checkbox"> Драмы <small>32</small></label><label><input type="checkbox"> Фантастика <small>54</small></label><label><input type="checkbox"> Триллеры <small>26</small></label><label><input type="checkbox"> Ужасы <small>27</small></label><label><input type="checkbox"> Приключения <small>38</small></label><label><input type="checkbox"> Мелодрамы <small>21</small></label>
            </fieldset>
            <label class="select-label">Год<select>
                    <option>Все годы</option>
                    <option>2020–2025</option>
                    <option>До 2020</option>
                </select></label>
            <fieldset>
                <legend>Рейтинг <em>от 4.0</em></legend><input class="range" type="range" min="0" max="5" value="4">
                <div class="range-labels"><span>0</span><span>5</span></div>
            </fieldset>
            <label class="switch-label">Уже смотрел <input type="checkbox"><span class="switch"></span></label>
            <button class="button button-primary apply-filters" type="button">Применить</button><button class="reset-filters" type="button">Сбросить фильтры</button>
        </aside>
        <section class="catalog-results" aria-labelledby="catalog-results-title">
            <form class="search-bar" role="search"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><input type="search" placeholder="Название фильма, режиссёр или актёр" aria-label="Поиск фильма"></form>
            <div class="results-toolbar"><b id="catalog-results-title">54 фильма</b><button type="button">По популярности⌄</button></div>
            <div class="active-filter">Рейтинг от 4.0 <button type="button" aria-label="Удалить фильтр">×</button></div>
            <div class="catalog-movie-grid">
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-francuzskij.jpeg")?>" alt="Французский диспетчер"><span class="hit-label">ХИТ</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                    <div class="movie-info"><span class="movie-genre">КОМЕДИЯ</span>
                        <h3>Французский диспетчер</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.8</span> <small>(128)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="Французский диспетчер">Оценить</button>
                    </div>
                </article>
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-daren.jpeg")?>" alt="Свет далёких улиц"><span class="hit-label teal">НОВИНКА</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                    <div class="movie-info"><span class="movie-genre">ДРАМА</span>
                        <h3>Свет далёких улиц</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.8</span> <small>(74)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="Свет далёких улиц">Оценить</button>
                    </div>
                </article>
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-gorod.jpeg")?>" alt="Город после полуночи"><span class="hit-label purple">ВЫБОР РЕДАКЦИИ</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                    <div class="movie-info"><span class="movie-genre">ФАНТАСТИКА</span>
                        <h3>Город после полуночи</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.7</span> <small>(96)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="Город после полуночи">Оценить</button>
                    </div>
                </article>
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-seans.jpeg")?>" alt="Последний сеанс"><span class="hit-label">ХИТ</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                    <div class="movie-info"><span class="movie-genre">ТРИЛЛЕР</span>
                        <h3>Последний сеанс</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.6</span> <small>(41)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="Последний сеанс">Оценить</button>
                    </div>
                </article>
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-mezhdu.jpeg")?>" alt="Между нами ночь"><span class="hit-label teal">НОВИНКА</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                    <div class="movie-info"><span class="movie-genre">ДРАМА</span>
                        <h3>Между нами ночь</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.5</span> <small>(53)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="Между нами ночь">Оценить</button>
                    </div>
                </article>
                <article class="movie-card">
                    <div class="movie-image"><img src="<?= Url::to("@web/images/catalog-predely.jpeg")?>" alt="За пределами сна"><span class="hit-label purple">ВЫБОР РЕДАКЦИИ</span><button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
                    <div class="movie-info"><span class="movie-genre">ФАНТАСТИКА</span>
                        <h3>За пределами сна</h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>4.7</span> <small>(82)</small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="За пределами сна">Оценить</button>
                    </div>
                </article>
            </div>
            <nav class="pagination" aria-label="Страницы каталога"><button>‹</button><button class="current">1</button><button>2</button><button>3</button><button>4</button><button>…</button><button>9</button><button>›</button><small>Показано 6 из 54 фильмов</small></nav>
        </section>
    </div>
</main>