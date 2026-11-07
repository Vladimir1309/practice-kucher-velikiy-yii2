<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $movies app\models\Movie[] */
/* @var $movieStates array */
/* @var $searchModel app\models\MovieSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $genres app\models\Genre[] */
/* @var $activeGenre app\models\Genre|null */
?>

<main class="catalog-page container">
    <div class="breadcrumbs">Главная <span>/</span> Каталог</div>
    <div class="catalog-heading">
        <div><span class="eyebrow">ВЫБЕРИТЕ НАСТРОЕНИЕ</span>
            <h1>Каталог фильмов</h1>
            <p>Найдите историю под своё настроение — и голосуйте за любимую.</p>
        </div><span class="catalog-note"><?= $activeGenre
            ? 'Жанр: ' . Html::encode($activeGenre->name)
            : 'Все фильмы для ваших вечеров' ?></span>
    </div>
    <button class="filter-toggle" type="button" aria-expanded="false" aria-controls="catalog-filters">Фильтры <span>☷</span></button>
    <div class="catalog-layout">
        <?= Html::beginForm(['site/catalog'], 'get', ['class' => 'filters-form']) ?>
        <aside class="catalog-filters" id="catalog-filters" aria-label="Фильтры каталога">
            <div class="filters-title"><b>Фильтры</b><button class="filter-close" type="button" aria-label="Закрыть фильтры">×</button><span>☷</span></div>
            <fieldset>
                <legend>Жанры</legend>
                <?= Html::radioList(
                    'MovieSearch[genre_id]',
                    $searchModel->genre_id,
                    ArrayHelper::map($genres, 'id', 'name'),
                    ['unselect' => null, 'class' => 'custom-radio-list']
                ) ?>
            </fieldset>
            <label class="select-label">Сортировка<?= Html::dropDownList('MovieSearch[sort]', $searchModel->sort, [
                'newest' => 'По новинкам',
                'title' => 'По алфавиту',
            ], ['class' => 'custom-select', 'prompt' => 'По популярности']) ?></label>
            <fieldset>
                <legend>Просмотренные</legend><?= Html::activeCheckbox($searchModel, 'is_watched', ['label' => 'Только просмотренные']) ?>
            </fieldset>
            <?= Html::submitButton('Применить', ['class' => 'button button-primary apply-filters']) ?>
            <?= Html::a('Сбросить', ['site/catalog'], ['class' => 'button button-secondary reset-filters']) ?>
        </aside>
        <?= Html::endForm() ?>
        <section class="catalog-results" aria-labelledby="catalog-results-title">
            <?= Html::beginForm(['site/catalog'], 'get', ['class' => 'search-form']) ?>
            <div class="search-bar-actions" role="search">
                <label class="search-bar"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><?= Html::textInput('MovieSearch[search]', $searchModel->search, ['class' => 'form-control', 'placeholder' => 'Название фильма...', 'aria-label' => 'Поиск фильма']) ?></label>
                <button type="submit" class="button button-primary search-submit"><i class="fas fa-search" aria-hidden="true"></i> Поиск</button>
            </div>
            <?= Html::endForm() ?>
            <div class="results-toolbar"><b id="catalog-results-title"><?= $dataProvider->getTotalCount() ?> фильмов</b></div>
            <?php if ($searchModel->min_rating): ?><div class="active-filter">Рейтинг от <?= Html::encode($searchModel->min_rating) ?></div><?php endif; ?>
            <div class="catalog-movie-grid">
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
                            <?php $isWatched = $movieStates[$movie->id]['is_watched'] ?? false; ?>
                            <button class="watched-button watched-icon<?= $isWatched ? ' watched-active' : '' ?>" data-id="<?= Html::encode($movie->id) ?>" aria-label="<?= $isWatched ? 'Отметить как непросмотренное' : 'Отметить как просмотренное' ?>"><i class="<?= $isWatched ? 'fa-solid' : 'fa-regular' ?> fa-eye" aria-hidden="true"></i></button>
                        </div>
                        <div class="movie-info"><span class="movie-genre"><?= Html::encode($movie->genre->name ?? 'Без жанра') ?></span>
                            <h3><?= Html::a($title, ['site/movie', 'id' => $movie->id]) ?></h3>
                            <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>—</span> <small><?= Html::encode($movie->year ?: 'Год не указан') ?></small></div><?= Html::a(
                                Yii::$app->user->isGuest ? 'Войти, чтобы оценить' : 'Оценить',
                                Yii::$app->user->isGuest ? ['site/login'] : ['site/votes', 'movie_id' => $movie->id],
                                [
                                    'class' => 'button button-primary review-button',
                                    'data-id' => Yii::$app->user->isGuest ? null : $movie->id,
                                    'data-auth-required' => Yii::$app->user->isGuest ? 'true' : 'false',
                                ]
                            ) ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <?= \yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </section>
    </div>
    
</main>