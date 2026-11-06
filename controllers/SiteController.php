<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Movie;
use app\models\Genre;
use app\models\UserMovie;
use app\models\MovieSearch;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'profile', 'votes', 'favorites', 'watched', 'settings', 'delete-review'],
                'rules' => [
                    [
                        'actions' => ['logout', 'profile', 'votes', 'favorites', 'watched', 'settings', 'delete-review'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $movies = Movie::find()->with('genre')->limit(4)->all();

        return $this->render('index', [
            'movies' => $movies,
            'movieStates' => $this->getMovieStates($movies),
        ]);
    }

    public function actionCatalog()
    {
        $searchModel = new MovieSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $movies = $dataProvider->getModels();
        $activeGenre = $searchModel->genre_id ? Genre::findOne($searchModel->genre_id) : null;

        return $this->render('catalog', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'genres' => Genre::find()->all(),
            'activeGenre' => $activeGenre,
            'movies' => $movies, // <--- ВОТ ЭТА СТРОКА РЕШАЕТ ВСЁ
            'movieStates' => $this->getMovieStates($movies),
        ]);
    }

    public function actionFavorites()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $movies = Movie::find()
            ->with('genre')
            ->innerJoin('user_movie', 'movie.id = user_movie.movie_id')
            ->where([
                'user_movie.user_id' => Yii::$app->user->id,
                'user_movie.is_favorite' => 1,
            ])
            ->all();

        return $this->render('favorites', [
            'movies' => $movies,
            'movieStates' => $this->getMovieStates($movies),
        ]);
    }

    public function actionMovie($id)
    {
        $movie = Movie::findOne($id);
        if ($movie === null) {
            throw new NotFoundHttpException('Фильм не найден.');
        }

        return $this->render('movie', [
            'movie' => $movie,
            'movieStates' => $this->getMovieStates([$movie]),
        ]);
    }

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;

        return $this->render('profile', [
            'user' => $user,
        ]);
    }

    public function actionSettings()
    {
        return $this->render('settings');
    }

    public function actionVotes($movie_id = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        if (Yii::$app->request->isPost) {
            $movieId = Yii::$app->request->post('movie_id');
            $movie = Movie::findOne($movieId);
            if ($movie === null) {
                throw new NotFoundHttpException('Фильм не найден.');
            }

            $reviewId = Yii::$app->request->post('review_id');
            $review = $reviewId
                ? UserMovie::findOne([
                    'id' => $reviewId,
                    'user_id' => Yii::$app->user->id,
                    'movie_id' => $movieId,
                ])
                : null;
            if ($reviewId && ($review === null || $review->rating === null)) {
                throw new NotFoundHttpException('Отзыв не найден.');
            }

            $exists = UserMovie::find()
                ->where([
                    'user_id' => Yii::$app->user->id,
                    'movie_id' => $movieId,
                ])
                ->andWhere(['is not', 'rating', null])
                ->exists();
            if (!$reviewId && $exists) {
                Yii::$app->session->setFlash('error', 'Вы уже оставили отзыв на этот фильм. Отредактируйте его в списке ниже.');
                return $this->redirect(['site/votes']);
            }

            if ($review === null) {
                $review = UserMovie::findOne([
                    'user_id' => Yii::$app->user->id,
                    'movie_id' => $movieId,
                ]);
            }
            if ($review === null) {
                $review = new UserMovie([
                    'user_id' => Yii::$app->user->id,
                    'movie_id' => $movieId,
                    'is_favorite' => false,
                    'is_watched' => false,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $review->rating = Yii::$app->request->post('rating');
            $review->comment = Yii::$app->request->post('comment');
            if (!$review->save()) {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить голос.');
                return $this->redirect(['site/votes']);
            }

            Yii::$app->session->setFlash('success', 'Голос сохранен!');
            return $this->redirect(['site/votes']);
        }

        $moviesList = Movie::find()->all();
        $myReviews = UserMovie::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['is not', 'rating', null])
            ->with(['movie.genre'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
        $reviewedMovieIds = ArrayHelper::getColumn($myReviews, 'movie_id');

        return $this->render('votes', [
            'movieId' => $movie_id,
            'moviesList' => $moviesList,
            'myReviews' => $myReviews,
            'reviewedMovieIds' => $reviewedMovieIds,
        ]);
    }

    public function actionDeleteReview($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $review = UserMovie::findOne([
            'id' => $id,
            'user_id' => Yii::$app->user->id,
        ]);
        if ($review === null || $review->rating === null) {
            throw new NotFoundHttpException('Отзыв не найден.');
        }

        if ($review->delete() === false) {
            Yii::$app->session->setFlash('error', 'Не удалось удалить отзыв.');
        } else {
            Yii::$app->session->setFlash('success', 'Отзыв удален');
        }

        return $this->redirect(['site/votes']);
    }

    public function actionWatched()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $movies = Movie::find()
            ->with('genre')
            ->innerJoin('user_movie', 'movie.id = user_movie.movie_id')
            ->where([
                'user_movie.user_id' => Yii::$app->user->id,
                'user_movie.is_watched' => 1,
            ])
            ->all();

        return $this->render('watched', [
            'movies' => $movies,
            'movieStates' => $this->getMovieStates($movies),
        ]);
    }

    private function getMovieStates(array $movies)
    {
        if (Yii::$app->user->isGuest || !$movies) {
            return [];
        }

        $movieIds = array_map(static function (Movie $movie) {
            return $movie->id;
        }, $movies);
        $states = [];
        foreach (
            UserMovie::find()->where([
                'user_id' => Yii::$app->user->id,
                'movie_id' => $movieIds,
            ])->all() as $userMovie
        ) {
            $states[$userMovie->movie_id] = [
                'is_favorite' => (bool) $userMovie->is_favorite,
                'is_watched' => (bool) $userMovie->is_watched,
            ];
        }

        return $states;
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \app\models\SignupForm();

        if ($model->load(Yii::$app->request->post()) && ($user = $model->signup())) {
            Yii::$app->user->login($user); // Автоматически логиним после регистрации
            return $this->redirect(['site/profile']);
        }

        return $this->render('register', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \app\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/profile']); // При успехе идем в профиль
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
