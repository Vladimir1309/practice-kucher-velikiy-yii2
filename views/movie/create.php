<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Movie */

$this->title = 'Создать фильм';
$this->params['breadcrumbs'][] = ['label' => 'Фильмы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-container movie-create">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', Yii::$app->request->referrer ?: ['index'], [
            'class' => 'btn btn-back-outline',
        ]) ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
