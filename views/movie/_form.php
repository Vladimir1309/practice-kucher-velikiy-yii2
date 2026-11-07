<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Movie */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-card-form movie-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <div class="admin-form-row">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'imageFile')->fileInput() ?>
        
        <?php if (!empty($model->poster_url)): ?>
            <!-- Здесь мы убрали дубль Yii::getAlias('@web') -->
            <img src="<?= Yii::getAlias('@web') . Html::encode($model->poster_url) ?>" alt="Постер фильма" width="150" style="border-radius: 8px; object-fit: cover; margin-top: 10px;">
        <?php endif; ?>
    </div>
    
    <div class="admin-form-row">
        <?= $form->field($model, 'year')->textInput() ?>
        <?= $form->field($model, 'duration')->textInput() ?>
        <?= $form->field($model, 'genre_id')->textInput() ?>
    </div>
    
    <div class="admin-form-row-full">
        <?= $form->field($model, 'description')->textarea(['rows' => 3, 'style' => 'width: 100%;']) ?>
    </div>

    <div class="form-group" style="margin-top: 30px; margin-bottom: 0;">
        <?= Html::submitButton('Сохранить', ['class' => 'button button-primary', 'style' => 'width: 100%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>