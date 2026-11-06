<?php

use yii\helpers\Html;
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
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['site/catalog'],
        'options' => ['class' => 'catalog-filter-form'],
    ]); ?>
    <div class="catalog-layout">
        <aside class="catalog-filters" id="catalog-filters" aria-label="Фильтры каталога">
            <div class="filters-title"><b>Фильтры</b><button class="filter-close" type="button" aria-label="Закрыть фильтры">×</button><span>☷</span></div>
            <fieldset>
                <legend>Жанры</legend>
                <label><?= Html::activeRadio($searchModel, 'genre_id', ['value' => '', 'unlabeled' => true]) ?> Все жанры</label>
                <?php foreach ($genres as $genre): ?>
                    <label><?= Html::activeRadio($searchModel, 'genre_id', ['value' => $genre->id, 'unlabeled' => true]) ?> <?= Html::encode($genre->name) ?></label>
                <?php endforeach; ?>
            </fieldset>
            <label class="select-label">Сортировка<?= Html::activeDropDownList($searchModel, 'sort', [
                'popular' => 'По популярности',
                'newest' => 'Сначала новые',
                'title' => 'По названию',
            ], ['prompt' => 'Выберите сортировку']) ?></label>
            <fieldset>
                <legend>Рейтинг</legend><?= Html::activeInput('number', $searchModel, 'min_rating', ['min' => 0, 'max' => 5, 'step' => '0.1', 'placeholder' => 'Например, 4.0']) ?>
            </fieldset>
            <fieldset>
                <legend>Просмотренные</legend><?= Html::activeCheckbox($searchModel, 'is_watched', ['label' => 'Только просмотренные', 'value' => 1]) ?>
            </fieldset>
            <button class="button button-primary apply-filters" type="submit">Применить</button>
            <?= Html::a('Сбросить', ['site/catalog'], ['class' => 'btn']) ?>
        </aside>
        <section class="catalog-results" aria-labelledby="catalog-results-title">
            <label class="search-bar" role="search"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><?= Html::activeTextInput($searchModel, 'search', ['placeholder' => 'Название фильма, режиссёр или актёр', 'aria-label' => 'Поиск фильма']) ?></label>
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
                        </div>
                        <div class="movie-info"><span class="movie-genre"><?= Html::encode($movie->genre->name ?? 'Без жанра') ?></span>
                            <h3><?= Html::a($title, ['site/movie', 'id' => $movie->id]) ?></h3>
                            <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>—</span> <small><?= Html::encode($movie->year ?: 'Год не указан') ?></small></div><?= Html::a('Оценить', ['site/votes', 'movie_id' => $movie->id], ['class' => 'button button-primary review-button', 'data-id' => $movie->id]) ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <?= \yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </section>
    </div>
    <?php ActiveForm::end(); ?>
</main>