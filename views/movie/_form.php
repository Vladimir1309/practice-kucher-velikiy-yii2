<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Movie */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-card-form movie-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="admin-form-grid">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'year')->textInput() ?>
        <?= $form->field($model, 'duration')->textInput() ?>
        <?= $form->field($model, 'poster_url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'genre_id')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
