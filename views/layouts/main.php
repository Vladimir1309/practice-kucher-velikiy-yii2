<?php

use yii\helpers\Url;
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineNight — кино, которое хочется смотреть вместе</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?= Url::to("@web/css/styles.css") ?>">
</head>

<body>
    <div class="page-shell">
        <header class="site-header">
            <div class="container header-inner">
                <a class="brand" href="index" aria-label="CineNight — главная">
                    <span class="brand-mark">C</span><span>CineNight</span>
                </a>
                <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">
                    <span></span><span></span><span></span><span class="sr-only">Открыть меню</span>
                </button>
                <nav class="primary-nav" id="primary-nav" aria-label="Основная навигация">
                    <a class="<?= Yii::$app->controller->route == 'site/index' ? 'active' : '' ?>" href="<?= Url::to(['/site/index']) ?>">Главная</a>
                    <a class="<?= Yii::$app->controller->route == 'site/catalog' ? 'active' : '' ?>" href="<?= Url::to(['/site/catalog']) ?>">Каталог</a>
                    <a class="<?= Yii::$app->controller->route == 'site/votes' ? 'active' : '' ?>" href="<?= Url::to(['/site/votes']) ?>">Мои голоса</a>
                    <!-- <a class="active" href="index">Главная</a>
                    <a href="catalog">Каталог</a>
                    <a href="votes">Мои голоса</a> -->
                </nav>
                <div class="header-actions"><a class="header-icon-btn" href="catalog" aria-label="Поиск"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></a><a class="header-icon-btn" href="favorites" aria-label="Избранное"><i class="fa-regular fa-heart" aria-hidden="true"></i></a><a class="header-icon-btn" href="login" aria-label="Профиль"><i class="fa-regular fa-user" aria-hidden="true"></i></a></div>
            </div>
        </header>

        <!-- <main> -->
        <?= $content ?>
        <!-- </main> -->

        <footer class="site-footer">
            <div class="container footer-grid">
                <div><a class="brand" href="index"><span class="brand-mark">C</span><span>CineNight</span></a>
                    <p>Фильмы для ваших вечеров, которые хочется запомнить.</p>
                </div>
                <div><b>КАТАЛОГ</b><a href="catalog">Новинки</a><a href="catalog">Популярное</a><a href="favorites">Подборки</a></div>
                <div><b>ПОМОЩЬ</b><a href="settings">Войти</a><a href="settings">Контакты</a><a href="settings">Поддержка</a></div>
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
            <p class="lucky-result"></p><a class="button button-primary" href="movie">Открыть фильм</a>
        </div>
    </div>
    <div class="modal" id="logout-modal" role="dialog" aria-modal="true" aria-labelledby="logout-title">
        <div class="modal-card"><button class="modal-close" type="button" aria-label="Закрыть">×</button><span class="eyebrow">ЛИЧНЫЙ КАБИНЕТ</span>
            <h2 id="logout-title">Выйти из аккаунта?</h2>
            <p>Вы сможете вернуться в любое время.</p>
            <div class="logout-actions"><button class="button button-secondary modal-close-action" type="button">Остаться</button><a class="button button-primary" href="login">Выйти</a></div>
        </div>
    </div>
    <script src="<?= Url::to("@web/js/script.js") ?>"></script>
</body>

</html>