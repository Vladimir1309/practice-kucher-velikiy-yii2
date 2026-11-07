<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
?>
<div class="admin-container user-index">

    <div style="margin-bottom: 20px;">
        <?= Html::a('<i class="fas fa-arrow-left"></i> Назад в админ-панель', ['admin/index'], ['class' => 'btn admin-back-button', 'style' => 'margin-left: 0; padding: 8px 20px !important; width: auto !important; display: inline-block !important;']) ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'button button-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            'id',
            [
                'attribute' => 'avatar',
                'label' => 'Аватар',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->avatar)) {
                        return Html::img(Yii::getAlias('@web') . Html::encode($model->avatar), [
                            'width' => '40px', 
                            'height' => '40px', 
                            'style' => 'border-radius: 50%; object-fit: cover;'
                        ]);
                    }
                    return '<span style="color: #666;">Нет</span>';
                },
            ],
            [
                'attribute' => 'username',
                'label' => 'Имя пользователя',
            ],
            [
                'attribute' => 'email',
                'label' => 'Email',
            ],
            [
                'attribute' => 'role_id',
                'label' => 'Роль',
                'value' => function ($model) {
                    return $model->role ? $model->role->name : 'Не задана';
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pen"></i>', $url, [
                            'class' => 'btn btn-primary btn-sm action-btn',
                            'title' => 'Редактировать',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        // Защита от удаления самого себя (админа)
                        if ($model->id === Yii::$app->user->id) {
                            return '';
                        }
                        return Html::beginForm($url, 'post', ['style' => 'display:inline;'])
                            . Html::submitButton('<i class="fas fa-trash"></i>', [
                                'class' => 'btn btn-danger btn-sm action-btn',
                                'title' => 'Удалить',
                                'onclick' => 'return confirm("Вы уверены, что хотите удалить этого пользователя?");',
                            ])
                            . Html::endForm();
                    },
                ],
            ],
        ],
    ]); ?>

</div>