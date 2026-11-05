<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm */
$this->title = 'Регистрация';
?>

<main class="auth-main">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'auth-card auth-form'],
        'action' => ['site/register'],
        'method' => 'post',
    ]); ?>

        <h1>Регистрация</h1>
        <p class="auth-subtitle">Ваши любимые фильмы — в одном месте.</p>

        <label>Имя
            <?= Html::activeTextInput($model, 'name', ['placeholder' => 'Как вас зовут?', 'required' => true]) ?>
        </label>
        <p class="form-error"><?= Html::error($model, 'name') ?></p>

        <label>Email
            <?= Html::activeTextInput($model, 'email', ['type' => 'email', 'placeholder' => 'Введите email', 'required' => true]) ?>
        </label>
        <p class="form-error"><?= Html::error($model, 'email') ?></p>

        <label>Пароль
            <div class="password-field">
                <?= Html::activePasswordInput($model, 'password', ['placeholder' => 'Придумайте пароль', 'required' => true]) ?>
                <button type="button" class="password-toggle" aria-label="Показать пароль">◉</button>
            </div>
        </label>
        <p class="form-error"><?= Html::error($model, 'password') ?></p>

        <label>Повторите пароль
            <div class="password-field">
                <?= Html::activePasswordInput($model, 'password_confirm', ['placeholder' => 'Повторите пароль', 'required' => true]) ?>
                <button type="button" class="password-toggle" aria-label="Показать пароль">◉</button>
            </div>
        </label>
        <p class="form-error"><?= Html::error($model, 'password_confirm') ?></p>

        <button class="button button-primary auth-submit" type="submit">Создать аккаунт</button>

        <p class="auth-switch">Уже есть аккаунт? <?= Html::a('Войти', ['site/login']) ?></p>

    <?php ActiveForm::end(); ?>
</main>