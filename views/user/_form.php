<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-card-form user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <!-- Блок работы с аватаркой -->
    <div style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #2a3248;">
        <?php if (!empty($model->avatar)): ?>
            <div style="margin-bottom: 15px;">
                <img src="<?= Yii::getAlias('@web') . Html::encode($model->avatar) ?>" width="100" style="border-radius: 50%; object-fit: cover;">
            </div>
        <?php endif; ?>
        <?= $form->field($model, 'imageFile')->fileInput() ?>
    </div>
    <!-- Конец блока аватарки -->

    <div class="admin-form-grid">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'birthdate')->textInput() ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'created_at')->textInput() ?>
        <?= $form->field($model, 'notify_news')->textInput() ?>
        <?= $form->field($model, 'notify_reminders')->textInput() ?>
        <?= $form->field($model, 'role_id')->textInput() ?>
    </div>

    <div class="form-group" style="margin-top: 30px; margin-bottom: 0;">
        <?= Html::submitButton('Сохранить', ['class' => 'button button-primary', 'style' => 'width: 100%;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>