<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\UserMovie;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'reviews'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity !== null
                            && Yii::$app->user->identity->role !== null
                            && Yii::$app->user->identity->role->name === 'admin';
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (
            Yii::$app->user->isGuest
            || Yii::$app->user->identity->role === null
            || Yii::$app->user->identity->role->name !== 'admin'
        ) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        return $this->render('index');
    }

    public function actionReviews()
    {
        if (
            Yii::$app->user->isGuest
            || Yii::$app->user->identity->role === null
            || Yii::$app->user->identity->role->name !== 'admin'
        ) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        $reviews = UserMovie::find()
            ->with(['user', 'movie'])
            ->where(['is not', 'rating', null])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('reviews', ['reviews' => $reviews]);
    }
}
