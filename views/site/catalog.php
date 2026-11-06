<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $movies app\models\Movie[] */
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
            <div class="results-toolbar"><b id="catalog-results-title"><?= count($movies) ?> фильмов</b><button type="button">По популярности⌄</button></div>
            <div class="active-filter">Рейтинг от 4.0 <button type="button" aria-label="Удалить фильтр">×</button></div>
            <div class="catalog-movie-grid">
                <?php foreach ($movies as $movie): ?>
                    <?php
                    $title = Html::encode($movie->title);
                    $poster = $movie->poster_url
                        ? Html::encode($movie->poster_url)
                        : Url::to('@web/images/movie-5.jpeg');
                    ?>
                    <article class="movie-card">
                        <div class="movie-image">
                            <?= Html::a('<img src="' . $poster . '" alt="' . $title . '"><span class="hit-label">ХИТ</span>', ['site/movie', 'id' => $movie->id], ['encode' => false]) ?>
                            <button class="save-button" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button>
                        </div>
                        <div class="movie-info"><span class="movie-genre">ФИЛЬМ</span>
                            <h3><?= Html::a($title, ['site/movie', 'id' => $movie->id]) ?></h3>
                            <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>—</span> <small><?= Html::encode($movie->year ?: 'Год не указан') ?></small></div><button class="button button-primary review-button" onclick="window.location.href='votes'" data-movie="<?= $title ?>">Оценить</button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <nav class="pagination" aria-label="Страницы каталога"><button>‹</button><button class="current">1</button><button>›</button><small>Показано <?= count($movies) ?> из <?= count($movies) ?> фильмов</small></nav>
        </section>
    </div>
</main>