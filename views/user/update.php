<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Редактировать пользователя: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="admin-container user-update">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', Yii::$app->request->referrer ?: ['index'], [
            'class' => 'back-btn-hover',
            'style' => 'display: inline-block; padding: 8px 20px; border-radius: 8px; border: 1px solid #ff4d94; color: #ff4d94; background: transparent; text-decoration: none; font-weight: 500; margin-bottom: 20px; transition: all 0.2s;'
        ]) ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
