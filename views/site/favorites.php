<?php

use yii\helpers\Html;

/* @var $movies app\models\Movie[] */
?>

<main class="user-page container">
    <div class="breadcrumbs">Главная <span>/</span> Личный кабинет</div>
    <div class="profile-layout">
        <aside class="account-sidebar">
            <?= $this->render('_account_user') ?>
            <nav class="account-nav">
                <?= Html::a('<i class="fa-regular fa-user" aria-hidden="true"></i> <span>Профиль</span>', ['site/profile'], ['encode' => false]) ?>
                <?= Html::a('<i class="fa-solid fa-star" aria-hidden="true"></i> <span>Мои голоса</span>', ['site/votes'], ['encode' => false]) ?>
                <?= Html::a('<i class="fa-regular fa-heart" aria-hidden="true"></i> <span>Избранное</span>', ['site/favorites'], ['class' => 'active', 'encode' => false]) ?>
                <?= Html::a('<i class="fa-solid fa-check" aria-hidden="true"></i> <span>Просмотренные</span>', ['site/watched'], ['encode' => false]) ?>
                <?= Html::a('<i class="fa-solid fa-gear" aria-hidden="true"></i> <span>Настройки</span>', ['site/settings'], ['encode' => false]) ?>
                <button type="button" class="logout-button"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i> <span>Выйти</span></button>
            </nav>
        </aside>
        <section class="collection-content">
            <span class="eyebrow">ВАШ ВЕЧЕР НАЧИНАЕТСЯ ЗДЕСЬ</span>
            <h1>Избранное</h1>
            <p class="profile-intro">Фильмы, которые хочется сохранить для особенного вечера.</p>
            <div class="collection-toolbar"><b><?= count($movies) ?> фильмов</b><?= Html::a('В каталог →', ['site/catalog']) ?></div>
            <div class="collection-grid"><?= $this->render('_movie_collection', ['movies' => $movies, 'type' => 'favorite']) ?></div>
        </section>
    </div>
</main>
