<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Genre */

$this->title = 'Создать жанр';
$this->params['breadcrumbs'][] = ['label' => 'Жанры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-container genre-create">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', ['index'], ['class' => 'button button-secondary']) ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
