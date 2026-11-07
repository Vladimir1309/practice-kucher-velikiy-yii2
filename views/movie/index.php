<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MovieSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фильмы';
?>
<div class="admin-container movie-index">

    <div style="margin-bottom: 20px;">
        <?= Html::a('<i class="fas fa-arrow-left"></i> Назад в админ-панель', ['admin/index'], ['class' => 'btn admin-back-button', 'style' => 'margin-left: 0; padding: 8px 20px !important; width: auto !important; display: inline-block !important;']) ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать фильм', ['create'], ['class' => 'button button-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            'id',
            [
                'attribute' => 'title',
                'label' => 'Название',
            ],
            [
                'attribute' => 'year',
                'label' => 'Год',
            ],
            [
                'attribute' => 'genre_id',
                'label' => 'Жанр',
                'value' => function ($model) {
                    return $model->genre ? $model->genre->name : 'Не указан';
                },
            ],
            [
                'attribute' => 'poster_url',
                'label' => 'Постер',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->poster_url ? Html::img(Yii::getAlias('@web') . $model->poster_url, ['width' => '50px', 'style' => 'border-radius: 4px;']) : 'Нет';
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
                        return Html::beginForm($url, 'post', ['style' => 'display:inline;'])
                            . Html::submitButton('<i class="fas fa-trash"></i>', [
                                'class' => 'btn btn-danger btn-sm action-btn',
                                'title' => 'Удалить',
                                'onclick' => 'return confirm("Вы уверены, что хотите удалить этот элемент?");',
                            ])
                            . Html::endForm();
                    },
                ],
            ],
        ],
    ]); ?>


</div>
