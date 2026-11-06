<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $movies app\models\Movie[] */
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
                <button class="<?= $isFavorite ? 'save-button active' : 'watched-button watched-active' ?>"
                        data-id="<?= Html::encode($movie->id) ?>"
                        aria-label="<?= $isFavorite ? 'Удалить из избранного' : 'Убрать из просмотренных' ?>">
                    <i class="fa-regular fa-heart" aria-hidden="true"></i>
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
