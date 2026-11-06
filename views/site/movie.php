<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $movie app\models\Movie */
$title = Html::encode($movie->title);
$poster = $movie->poster_url
    ? Html::encode($movie->poster_url)
    : Url::to('@web/images/movie-5.jpeg');
$description = Html::encode($movie->description ?: 'Описание фильма пока не добавлено.');
?>

<main class="movie-page container">
    <div class="breadcrumbs">Главная <span>/</span> Каталог <span>/</span> <?= $title ?></div>
    <div class="movie-detail-grid">
        <div class="detail-left">
            <div class="detail-poster"><img src="<?= $poster ?>" alt="<?= $title ?>"><span class="hit-label">ХИТ</span><button class="save-button" data-id="<?= Html::encode($movie->id) ?>" aria-label="Добавить в избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></button></div>
            <section class="detail-tabs">
                <div class="tab-list" role="tablist"><button class="tab is-active" role="tab" aria-selected="true" aria-controls="description-panel" data-tab="description-panel">Описание</button><button class="tab" role="tab" aria-selected="false" aria-controls="reviews-panel" data-tab="reviews-panel">Отзывы</button></div>
                <div class="tab-panel is-active" id="description-panel" role="tabpanel">
                    <h2>О фильме</h2>
                    <p><?= $description ?></p>
                    <dl>
                        <div>
                            <dt>Режиссёр</dt>
                            <dd>Уэс Андерсон</dd>
                        </div>
                        <div>
                            <dt>Страна</dt>
                            <dd>США, Германия</dd>
                        </div>
                        <div>
                            <dt>В ролях</dt>
                            <dd>Билл Мюррей, Тильда Суинтон, Тимоти Шаламе, Фрэнсис Макдорманд</dd>
                        </div>
                    </dl>
                </div>
                <div class="tab-panel" id="reviews-panel" role="tabpanel" hidden>
                    <h2>Отзывы</h2>
                    <div class="review-item"><b><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i></b>
                        <p>«Очень красивое и уютное кино. Каждый кадр хочется поставить на заставку.В»</p><small>Алина, 2 дня назад</small>
                    </div>
                    <div class="review-item"><b><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-regular fa-star" aria-hidden="true"></i></b>
                        <p>«Отличный выбор для спокойного вечера.В»</p><small>Михаил, неделю назад</small>
                    </div>
                </div>
            </section>
        </div>
        <aside class="movie-summary">
            <span class="eyebrow">ВАШ ВЕЧЕР НАЧИНАЕТСЯ ЗДЕСЬ</span>
            <h1><?= $title ?></h1>
            <p class="movie-meta"><?= Html::encode($movie->year ?: 'Год не указан') ?></p>
            <div class="movie-tags"><span>Комедия</span><span>Драма</span></div>
            <div class="detail-rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <strong>4.9</strong> <small>В· 125 оценок</small></div>
            <p class="summary-copy"><?= $description ?></p>
            <button class="button button-primary vote-button" onclick="window.location.href='votes'" data-movie="<?= $title ?>">Оценить</button>
            <button class="button button-secondary watched-button" data-id="<?= Html::encode($movie->id) ?>">Отметить как просмотренное</button>
            <div class="community-votes"><b>Голосов сообщества: 45</b><span class="vote-bar"><i></i></span><small>Выбираем вместе, что смотреть сегодня.</small></div>
        </aside>
    </div>
</main>