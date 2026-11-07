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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            'id',
            'name',

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
                        // Используем HTML-форму с методом POST вместо ссылки. 
                        // Это полностью обходит необходимость в yii.js для удаления.
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
