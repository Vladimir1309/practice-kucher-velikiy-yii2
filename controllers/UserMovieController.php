<?php

namespace app\controllers;

use Yii;
use app\models\Movie;
use app\models\UserMovie;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserMovieController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'toggle' => ['post'],
                ],
            ],
        ];
    }

    public function actionToggle()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $type = Yii::$app->request->post('type');
        if (!in_array($type, ['favorite', 'watched'], true)) {
            Yii::$app->response->statusCode = 400;
            return ['success' => false, 'error' => 'Недопустимый тип действия.'];
        }

        $movieId = Yii::$app->request->post('movie_id');
        if (Movie::findOne($movieId) === null) {
            throw new NotFoundHttpException('Фильм не найден.');
        }

        $model = UserMovie::findOne([
            'user_id' => Yii::$app->user->id,
            'movie_id' => $movieId,
        ]);
        if ($model === null) {
            $model = new UserMovie([
                'user_id' => Yii::$app->user->id,
                'movie_id' => $movieId,
                'created_at' => date('Y-m-d H:i:s'),
                'is_favorite' => false,
                'is_watched' => false,
            ]);
        }

        $attribute = $type === 'favorite' ? 'is_favorite' : 'is_watched';
        $model->$attribute = !$model->$attribute;
        if (!$model->save()) {
            Yii::$app->response->statusCode = 422;
            return ['success' => false, 'error' => 'Не удалось сохранить состояние фильма.'];
        }

        return [
            'success' => true,
            'state' => (bool) $model->$attribute,
        ];
    }
}
