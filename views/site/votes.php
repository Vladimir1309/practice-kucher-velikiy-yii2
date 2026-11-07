<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $movieId int|null */
/* @var $moviesList app\models\Movie[] */
/* @var $myReviews app\models\UserMovie[] */
/* @var $reviewedMovieIds int[] */

$movieItems = ArrayHelper::map($moviesList, 'id', 'title');
$movieOptions = [];
foreach ($moviesList as $movie) {
    $isReviewed = in_array((int) $movie->id, array_map('intval', $reviewedMovieIds), true);
    if ($isReviewed) {
        $movieItems[$movie->id] .= ' (Уже оценен)';
        $movieOptions[$movie->id] = ['disabled' => true];
    }
}
$reviewCount = count($myReviews);
$visibleReviews = array_slice($myReviews, 0, 3);
?>

<main class="votes-page container">
    <div class="breadcrumbs">Главная <span>/</span> Личный кабинет</div>
    <div class="profile-layout">
        <aside class="account-sidebar" aria-label="Навигация профиля">
            <?= $this->render('_account_user') ?>
            <nav class="account-nav">
                <?= Html::a('<i class="fa-regular fa-user" aria-hidden="true"></i> <span>Профиль</span>', ['site/profile'], ['encode' => false]) ?>
                <?= Html::a('<i class="fa-solid fa-star" aria-hidden="true"></i> <span>Мои голоса</span><small>' . $reviewCount . '</small>', ['site/votes'], ['class' => 'active', 'encode' => false]) ?>
                <?= Html::a('<i class="fa-regular fa-heart" aria-hidden="true"></i> <span>Избранное</span>', ['site/favorites'], ['encode' => false]) ?>
                <?= Html::a('<i class="fa-solid fa-check" aria-hidden="true"></i> <span>Просмотренные</span>', ['site/watched'], ['encode' => false]) ?>
                <?= Html::a('<i class="fa-solid fa-gear" aria-hidden="true"></i> <span>Настройки</span>', ['site/settings'], ['encode' => false]) ?>
                <button type="button" class="logout-button"><i class="fa-solid fa-arrow-right-from-bracket"
                        aria-hidden="true"></i> <span>Выйти</span></button>
            </nav>
        </aside>
        <section class="votes-content" aria-labelledby="votes-title">
            <span class="eyebrow">ВАШ ВЕЧЕР НАЧИНАЕТСЯ ЗДЕСЬ</span>
            <h1 id="votes-title">Мои голоса <sup><?= $reviewCount ?></sup></h1>
            <p class="profile-intro">Ваши любимые истории — и планы на следующий киновечер.</p>
            <div class="reviewed-movies">
                <?php if (!$myReviews): ?>
                    <p class="empty-state">Вы пока не оставили ни одного голоса.</p>
                <?php else: ?>
                    <?php foreach ($visibleReviews as $review): ?>
                        <?php
                        $reviewTitle = $review->movie ? $review->movie->title : 'Фильм удален';
                        $reviewPoster = $review->movie && $review->movie->poster_url
                            ? $review->movie->poster_url
                            : Url::to('@web/images/movie-5.jpeg');
                        $reviewGenre = $review->movie && $review->movie->genre
                            ? $review->movie->genre->name
                            : 'Без жанра';
                        ?>
                        <article class="reviewed-card"
                            data-review-id="<?= (int) $review->id ?>"
                            data-movie-id="<?= (int) $review->movie_id ?>"
                            data-movie="<?= Html::encode($reviewTitle) ?>"
                            data-rating="<?= (int) $review->rating ?>"
                            data-comment="<?= Html::encode($review->comment ?: '') ?>"
                            data-poster="<?= Html::encode($reviewPoster) ?>"
                            tabindex="0">
                            <img src="<?= Html::encode($reviewPoster) ?>" alt="<?= Html::encode($reviewTitle) ?>">
                            <div>
                                <span class="movie-genre"><?= Html::encode($reviewGenre) ?></span>
                                <h2><?= Html::encode($reviewTitle) ?></h2>
                                <div class="rating">
                                    <?php for ($star = 1; $star <= 5; $star++): ?>
                                        <i class="<?= $star <= (int) $review->rating ? 'fa-solid' : 'fa-regular' ?> fa-star" aria-hidden="true"></i>
                                    <?php endfor; ?>
                                    <span><?= (int) $review->rating ?></span>
                                </div>
                                <b class="voted-label">◉ Голос учтён</b>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    <?php if ($reviewCount > 3): ?>
                        <div class="show-all-reviews-wrapper">
                            <button id="show-all-reviews" class="btn btn-secondary" type="button">
                                Показать все отзывы (<?= count($myReviews) ?>) <i class="fas fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <p class="alert alert-success"><?= Html::encode(Yii::$app->session->getFlash('success')) ?></p>
            <?php endif; ?>
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <p class="alert alert-danger"><?= Html::encode(Yii::$app->session->getFlash('error')) ?></p>
            <?php endif; ?>
            <form class="vote-form" method="post" action="<?= Url::to(['site/votes']) ?>">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                <?= Html::hiddenInput('review_id', '', ['id' => 'review-id']) ?>
                <div class="vote-form-heading"><span class="form-icon"><i class="fa-solid fa-star"
                            aria-hidden="true"></i></span>
                    <div>
                        <h2>Оценить фильм</h2>
                        <p>Выберите фильм, оцените его и добавьте комментарий. Мы сохраним ваш голос.</p>
                    </div>
                </div>
                <div class="vote-fields">
                    <label>Фильм <em>*</em><?= Html::dropDownList('movie_id', $movieId, $movieItems, [
                        'prompt' => 'Выберите фильм',
                        'required' => true,
                        'options' => $movieOptions,
                    ]) ?></label>
                    <fieldset>
                        <legend>Ваша оценка <em>*</em></legend>
                        <div class="vote-stars" role="group" aria-label="Выберите рейтинг"><button type="button"
                                data-rating="1"><i class="fa-solid fa-star" aria-hidden="true"></i></button><button type="button"
                                data-rating="2"><i class="fa-solid fa-star" aria-hidden="true"></i></button><button type="button"
                                data-rating="3"><i class="fa-solid fa-star" aria-hidden="true"></i></button><button type="button"
                                data-rating="4"><i class="fa-solid fa-star" aria-hidden="true"></i></button><button type="button"
                                data-rating="5"><i class="fa-solid fa-star" aria-hidden="true"></i></button></div>
                        <?= Html::hiddenInput('rating', '', ['id' => 'rating-value']) ?>
                        <small id="rating-error" class="rating-error" hidden>Выберите оценку от 1 до 5.</small>
                    </fieldset>
                    <label class="comment-label">Комментарий <span>Необязательно</span><textarea rows="4"
                            name="comment" placeholder="Хочется атмосферного кино для пятничного вечера. Соберёмся вместе?"></textarea></label>
                </div>
                <small class="required-note"><em>*</em> Обязательные поля</small>
                <div class="form-actions"><button class="button button-primary" type="submit">Сохранить голос
                        <span>→</span></button><small>Ваш выбор поможет решить, что отсмотрим вместе.</small></div>
            </form>
        </section>
    </div>
</main>

<div class="modal" id="review-modal" role="dialog" aria-modal="true" aria-labelledby="review-title">
    <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span
            class="eyebrow">ВАША ОЦЕНКА</span>
        <h2 id="review-title">Оценить фильм</h2>
        <p id="review-movie"></p>
        <img id="review-poster" class="review-modal-poster" src="" alt="">
        <div class="stars" role="group" aria-label="Выберите рейтинг"><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star"
                    aria-hidden="true"></i></button><button><i class="fa-solid fa-star" aria-hidden="true"></i></button></div>
        <p id="review-comment"></p>
        <div class="review-modal-actions">
            <button type="button" class="button button-secondary review-edit-button">Редактировать</button>
            <?= Html::a('Удалить отзыв', ['site/delete-review'], [
                'id' => 'delete-review-button',
                'class' => 'button button-danger',
                'onclick' => "return confirm('Вы уверены, что хотите удалить отзыв?');",
            ]) ?>
        </div>
    </div>
</div>
<?php if ($reviewCount > 3): ?>
    <div class="modal all-reviews-modal" id="all-reviews-modal" role="dialog" aria-modal="true" aria-labelledby="all-reviews-title">
        <div class="modal-card all-reviews-modal-card">
            <button class="modal-close" type="button" aria-label="Закрыть">×</button>
            <span class="eyebrow">ВАШИ ОТЗЫВЫ</span>
            <h2 id="all-reviews-title">Все отзывы (<?= $reviewCount ?>)</h2>
            <div class="all-reviews-list">
                <?php foreach ($myReviews as $review): ?>
                    <?php
                    $reviewTitle = $review->movie ? $review->movie->title : 'Фильм удален';
                    $reviewPoster = $review->movie && $review->movie->poster_url
                        ? $review->movie->poster_url
                        : Url::to('@web/images/movie-5.jpeg');
                    ?>
                    <article class="reviewed-card all-review-card"
                        data-review-id="<?= (int) $review->id ?>"
                        data-movie-id="<?= (int) $review->movie_id ?>"
                        data-movie="<?= Html::encode($reviewTitle) ?>"
                        data-rating="<?= (int) $review->rating ?>"
                        data-comment="<?= Html::encode($review->comment ?: '') ?>"
                        data-poster="<?= Html::encode($reviewPoster) ?>">
                        <img src="<?= Html::encode($reviewPoster) ?>" alt="<?= Html::encode($reviewTitle) ?>">
                        <div>
                            <h3><?= Html::encode($reviewTitle) ?></h3>
                            <div class="rating">
                                <?php for ($star = 1; $star <= 5; $star++): ?>
                                    <i class="<?= $star <= (int) $review->rating ? 'fa-solid' : 'fa-regular' ?> fa-star" aria-hidden="true"></i>
                                <?php endfor; ?>
                                <span><?= (int) $review->rating ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="modal" id="logout-modal" role="dialog" aria-modal="true" aria-labelledby="logout-title">
    <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span
            class="eyebrow">ЛИЧНЫЙ КАБИНЕТ</span>
        <h2 id="logout-title">Выйти из аккаунта?</h2>
        <p>Вы сможете вернуться в любое время.</p>
        <div class="logout-actions"><button class="button button-secondary modal-close-action"
                type="button">Остаться</button><a class="button button-primary" href="<?= Url::to(['site/logout']) ?>">Выйти</a></div>
    </div>
</div>