<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isGuest = Yii::$app->user->isGuest;
$accountRoute = $isGuest ? ['site/login'] : ['site/profile'];
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title>CineNight — кино, которое хочется смотреть вместе</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?= Url::to("@web/css/styles.css") ?>">
</head>

<body data-user-movie-toggle-url="<?= Url::to(['/user-movie/toggle']) ?>">
    <div class="page-shell">
        <header class="site-header">
            <div class="container header-inner">
                <?= Html::a('<span class="brand-mark">C</span><span>CineNight</span>', ['site/index'], [
                    'class' => 'brand',
                    'aria-label' => 'CineNight — главная',
                    'encode' => false,
                ]) ?>
                <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">
                    <span></span><span></span><span></span><span class="sr-only">Открыть меню</span>
                </button>
                <nav class="primary-nav" id="primary-nav" aria-label="Основная навигация">
                    <?= Html::a('Главная', ['site/index'], [
                        'class' => Yii::$app->controller->route == 'site/index' ? 'active' : '',
                    ]) ?>
                    <?= Html::a('Каталог', ['site/catalog'], [
                        'class' => Yii::$app->controller->route == 'site/catalog' ? 'active' : '',
                    ]) ?>
                    <?= Html::a('Мои голоса', ['site/votes'], [
                        'class' => Yii::$app->controller->route == 'site/votes' ? 'active' : '',
                    ]) ?>
                </nav>
                <div class="header-actions">
                    <?= Html::a('<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>', ['site/catalog'], [
                        'class' => 'header-icon-btn',
                        'aria-label' => 'Поиск',
                        'encode' => false,
                    ]) ?>
                    <?= Html::a('<i class="fa-regular fa-heart" aria-hidden="true"></i>', ['site/favorites'], [
                        'class' => 'header-icon-btn',
                        'aria-label' => 'Избранное',
                        'encode' => false,
                    ]) ?>
                    <?= Html::a('<i class="fa-regular fa-user" aria-hidden="true"></i>', $accountRoute, [
                        'class' => 'header-icon-btn',
                        'aria-label' => $isGuest ? 'Войти' : 'Профиль',
                        'encode' => false,
                    ]) ?>
                </div>
            </div>
        </header>

        <!-- <main> -->
        <?= $content ?>
        <!-- </main> -->

        <footer class="site-footer">
            <div class="container footer-grid">
                <div><?= Html::a('<span class="brand-mark">C</span><span>CineNight</span>', ['site/index'], [
                        'class' => 'brand',
                        'encode' => false,
                    ]) ?>
                    <p>Фильмы для ваших вечеров, которые хочется запомнить.</p>
                </div>
                <div><b>КАТАЛОГ</b><?= Html::a('Новинки', ['site/catalog']) ?><?= Html::a('Популярное', ['site/catalog']) ?><?= Html::a('Подборки', ['site/favorites']) ?></div>
                <div><b>ПОМОЩЬ</b><?= Html::a($isGuest ? 'Войти' : 'Профиль', $accountRoute) ?><?= Html::a('Контакты', ['site/contact']) ?><?= Html::a('Поддержка', ['site/contact']) ?></div>
                <div><b>КИНОПИСЬМО</b>
                    <p>Следите за новостями кино.</p><button type="button" class="btn-subscribe">Подписаться</button>
                </div>
            </div>
        </footer>
    </div>

    <div class="modal" id="review-modal" role="dialog" aria-modal="true" aria-labelledby="review-title">
        <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span class="eyebrow">ВАША ОЦЕНКА</span>
            <h2 id="review-title">Оценить фильм</h2>
            <p id="review-movie"></p>
            <div class="stars" role="group" aria-label="Выберите рейтинг"><button><i class="fa-solid fa-star" aria-hidden="true"></i></button><button><i class="fa-solid fa-star" aria-hidden="true"></i></button><button><i class="fa-solid fa-star" aria-hidden="true"></i></button><button><i class="fa-solid fa-star" aria-hidden="true"></i></button><button><i class="fa-solid fa-star" aria-hidden="true"></i></button></div><button class="button button-primary modal-submit">Сохранить оценку</button>
        </div>
    </div>
    <div class="modal" id="lucky-modal" role="dialog" aria-modal="true" aria-labelledby="lucky-title">
        <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span class="eyebrow">ВАМ ПОВЕЗЛО</span>
            <h2 id="lucky-title">Сегодня смотрим:</h2>
            <p class="lucky-result"></p><?= Html::a('Открыть фильм', ['site/movie'], ['class' => 'button button-primary']) ?>
        </div>
    </div>
    <div class="modal" id="logout-modal" role="dialog" aria-modal="true" aria-labelledby="logout-title">
        <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span class="eyebrow">ЛИЧНЫЙ КАБИНЕТ</span>
            <h2 id="logout-title">Выйти из аккаунта?</h2>
            <p>Вы сможете вернуться в любое время.</p>
            <div class="logout-actions"><button class="button button-secondary modal-close-action" type="button">Остаться</button><?= Html::a('Выйти', ['site/logout'], [
                    'class' => 'button button-primary',
                    'data-method' => 'post',
                ]) ?></div>
        </div>
    </div>
    <script src="<?= Url::to("@web/js/script.js") ?>"></script>
</body>

</html>