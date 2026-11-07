<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Genre */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-card-form genre-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="admin-form-grid">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="form-group" style="margin-top: 10px;">
        <?= Html::a('Назад', Yii::$app->request->referrer ?: ['index'], ['class' => 'btn admin-back-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
