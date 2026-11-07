<?php

use yii\helpers\Html;

/* @var $reviews app\models\UserMovie[] */
?>

<main class="admin-container admin-reviews">
    <h1>Отзывы пользователей</h1>

    <div class="table-responsive">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Фильм</th>
                    <th>Оценка</th>
                    <th>Комментарий</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?= (int) $review->id ?></td>
                        <td><?= Html::encode($review->user ? $review->user->username : '—') ?></td>
                        <td><?= Html::encode($review->movie ? $review->movie->title : '—') ?></td>
                        <td><?= (int) $review->rating ?>/5</td>
                        <td><?= Html::encode(mb_strimwidth((string) $review->comment, 0, 120, '…')) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
