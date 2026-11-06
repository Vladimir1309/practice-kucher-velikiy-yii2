<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GenreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Жанры';
?>
<div class="admin-container genre-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать жанр', ['create'], ['class' => 'button button-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pen"></i>', $url, [
                            'class' => 'btn btn-primary btn-sm',
                            'title' => 'Редактировать',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                            'class' => 'btn btn-danger btn-sm',
                            'title' => 'Удалить',
                            'aria-label' => 'Удалить',
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
