<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $movies app\models\Movie[] */
/* @var $movieStates array */
?>

<main>
    <section class="hero container">
        <div class="hero-copy">
            <span class="eyebrow">ПОДБОРКА НЕДЕЛИ</span>
            <h1>Кино, которое<br>хочется смотреть<br>вместе</h1>
            <p>Тёплые истории, яркое приключение и немного магии — мы уже собрали идеальный вечер для вас.</p>
            <div class="hero-actions">
                <button class="button button-primary" type="button" id="hero-lucky-button">Мне повезёт <span>→</span></button>
                <?= Html::a('Тайное кино', ['site/catalog'], ['class' => 'button button-secondary']) ?>
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
            <?= Html::a('Все категории <span>→</span>', ['site/catalog'], ['class' => 'text-link', 'encode' => false]) ?>
        </div>
        <div class="genre-grid">
            <?= Html::a('<span class="genre-icon comedy">✦</span><span><b>Комедии</b><small>48 фильмов</small></span><span>›</span>', ['site/catalog', 'MovieSearch[genre_id]' => 1], ['class' => 'genre-chip', 'encode' => false]) ?>
            <?= Html::a('<span class="genre-icon drama">✦</span><span><b>Драмы</b><small>32 фильма</small></span><span>›</span>', ['site/catalog', 'MovieSearch[genre_id]' => 2], ['class' => 'genre-chip', 'encode' => false]) ?>
            <?= Html::a('<span class="genre-icon horror">☾</span><span><b>Ужасы</b><small>27 фильмов</small></span><span>›</span>', ['site/catalog', 'MovieSearch[genre_id]' => 3], ['class' => 'genre-chip', 'encode' => false]) ?>
            <?= Html::a('<span class="genre-icon fantasy">✺</span><span><b>Фантастика</b><small>54 фильма</small></span><span>›</span>', ['site/catalog', 'MovieSearch[genre_id]' => 4], ['class' => 'genre-chip', 'encode' => false]) ?>
        </div>
    </section>

    <section class="hits container" id="hits" aria-labelledby="hits-title">
        <div class="section-heading">
            <div><span class="eyebrow">ГОРЯЧОЕ СЕГОДНЯ</span>
                <h2 id="hits-title">Хиты вечера</h2>
                <p>Самые любимые фильмы нашего сообщества.</p>
            </div>
            <?= Html::a('В каталог', ['site/catalog'], ['class' => 'button button-light']) ?>
        </div>
        <div class="movie-grid">
            <?php foreach ($movies as $movie): ?>
                <?php
                $title = Html::encode($movie->title);
                $poster = $movie->poster_url
                    ? Html::encode($movie->poster_url)
                    : Url::to('@web/images/movie-5.jpeg');
                ?>
                <article class="movie-card" data-id="<?= Html::encode($movie->id) ?>">
                    <div class="movie-image">
                        <?= Html::a('<img src="' . $poster . '" alt="' . $title . '"><span class="hit-label">ХИТ</span>', ['site/movie', 'id' => $movie->id], ['encode' => false]) ?>
                        <?php $isFavorite = $movieStates[$movie->id]['is_favorite'] ?? false; ?>
                        <button class="save-button<?= $isFavorite ? ' active' : '' ?>" data-id="<?= Html::encode($movie->id) ?>" aria-label="<?= $isFavorite ? 'Удалить из избранного' : 'Добавить в избранное' ?>"><i class="<?= $isFavorite ? 'fa-solid' : 'fa-regular' ?> fa-heart" aria-hidden="true"></i></button>
                    </div>
                    <div class="movie-info"><span class="movie-genre"><?= Html::encode($movie->genre->name ?? 'Без жанра') ?></span>
                        <h3><?= Html::a($title, ['site/movie', 'id' => $movie->id]) ?></h3>
                        <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>—</span> <small><?= Html::encode($movie->year ?: 'Год не указан') ?></small></div><?= Html::a('Оценить', ['site/votes', 'movie_id' => $movie->id], ['class' => 'button button-primary review-button', 'data-id' => $movie->id, 'data-movie' => $title]) ?>
                    </div>
                </article>
            <?php endforeach; ?>
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