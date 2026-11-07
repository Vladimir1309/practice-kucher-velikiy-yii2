<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>

<main class="admin-dashboard container">
    <h1>Панель администратора</h1>
    <p>Вы вошли как: <?= Html::encode(Yii::$app->user->identity->username) ?></p>

    <section class="admin-card-grid">
        <?php foreach ([
            ['icon' => 'fa-tags', 'title' => 'Жанры', 'route' => ['genre/index']],
            ['icon' => 'fa-film', 'title' => 'Фильмы', 'route' => ['movie/index']],
            ['icon' => 'fa-users', 'title' => 'Пользователи', 'route' => ['user/index']],
            ['icon' => 'fa-star', 'title' => 'Отзывы', 'route' => ['admin/reviews']],
        ] as $card): ?>
            <article class="admin-card">
                <i class="fa-solid <?= Html::encode($card['icon']) ?>" aria-hidden="true"></i>
                <h2><?= Html::encode($card['title']) ?></h2>
                <?= Html::a('Открыть', $card['route'], ['class' => 'button button-primary']) ?>
            </article>
        <?php endforeach; ?>
    </section>
</main>
