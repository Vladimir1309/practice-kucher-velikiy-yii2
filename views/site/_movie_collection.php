<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $movies app\models\Movie[] */
/* @var $movieStates array */
/* @var $type string */
$isFavorite = $type === 'favorite';
?>

<?php if (!$movies): ?>
    <p class="profile-intro"><?= $isFavorite ? 'У вас пока нет избранных фильмов' : 'У вас пока нет просмотренных фильмов' ?></p>
<?php else: ?>
    <?php foreach ($movies as $movie): ?>
        <?php
        $title = Html::encode($movie->title);
        $poster = $movie->poster_url
            ? Html::encode($movie->poster_url)
            : Url::to('@web/images/movie-5.jpeg');
        ?>
        <article class="movie-card" data-id="<?= Html::encode($movie->id) ?>">
            <div class="movie-image">
                <?= Html::a('<img src="' . $poster . '" alt="' . $title . '">', ['site/movie', 'id' => $movie->id], ['encode' => false]) ?>
                <?php $isMovieFavorite = $movieStates[$movie->id]['is_favorite'] ?? false; ?>
                <button class="save-button<?= $isMovieFavorite ? ' active' : '' ?>"
                        data-id="<?= Html::encode($movie->id) ?>"
                        aria-label="<?= $isMovieFavorite ? 'Удалить из избранного' : 'Добавить в избранное' ?>">
                    <i class="<?= $isMovieFavorite ? 'fa-solid' : 'fa-regular' ?> fa-heart" aria-hidden="true"></i>
                </button>
                <?php $isMovieWatched = $movieStates[$movie->id]['is_watched'] ?? false; ?>
                <button class="watched-button watched-icon<?= $isMovieWatched ? ' watched-active' : '' ?>"
                        data-id="<?= Html::encode($movie->id) ?>"
                        aria-label="<?= $isMovieWatched ? 'Отметить как непросмотренное' : 'Отметить как просмотренное' ?>">
                    <i class="<?= $isMovieWatched ? 'fa-solid' : 'fa-regular' ?> fa-eye" aria-hidden="true"></i>
                </button>
            </div>
            <div class="movie-info">
                <span class="movie-genre"><?= Html::encode($movie->genre->name ?? 'Без жанра') ?></span>
                <h3><?= Html::a($title, ['site/movie', 'id' => $movie->id]) ?></h3>
                <div class="rating"><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i> <span>—</span> <small><?= Html::encode($movie->year ?: 'Год не указан') ?></small></div>
                <button class="button button-primary review-button" data-movie="<?= $title ?>">Оценить</button>
            </div>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
