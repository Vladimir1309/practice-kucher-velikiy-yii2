<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>

<main class="admin-dashboard container">
    <span class="eyebrow">CINENIGHT</span>
    <h1>Панель администратора</h1>
    <p>Вы вошли как: <?= Html::encode(Yii::$app->user->identity->username) ?></p>

    <section class="admin-card">
        <h2>Управление каталогом</h2>
        <?= Html::a('Управление жанрами', ['genre/index'], ['class' => 'button button-primary']) ?>
    </section>
</main>
