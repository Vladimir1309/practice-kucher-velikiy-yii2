<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */
$this->title = 'Вход';
?>

<main class="auth-main">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'auth-card auth-form'],
        'action' => ['site/login'],
        'method' => 'post',
    ]); ?>

        <h1>Вход</h1>
        <p class="auth-subtitle">С возвращением в CineNight.</p>

        <label>Email
            <?= Html::activeTextInput($model, 'email', ['type' => 'email', 'placeholder' => 'Введите email', 'required' => true]) ?>
        </label>
        <p class="form-error"><?= Html::error($model, 'email') ?></p>

        <label>Пароль
            <div class="password-field">
                <?= Html::activePasswordInput($model, 'password', ['placeholder' => 'Введите пароль', 'required' => true]) ?>
                <button type="button" class="password-toggle" aria-label="Показать пароль">◉</button>
            </div>
        </label>
        <p class="form-error"><?= Html::error($model, 'password') ?></p>

        <button class="button button-primary auth-submit" type="submit">Войти</button>

        <p class="auth-switch">Нет аккаунта? <?= Html::a('Зарегистрироваться', ['site/register']) ?></p>

    <?php ActiveForm::end(); ?>
</main>