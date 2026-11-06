<?php

use yii\helpers\Html;

/* @var $users app\models\User[] */
?>

<main class="container">
    <h1>Панель администратора</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Роль</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= (int) $user->id ?></td>
                    <td><?= Html::encode($user->username) ?></td>
                    <td><?= Html::encode($user->email) ?></td>
                    <td><?= Html::encode($user->role) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
