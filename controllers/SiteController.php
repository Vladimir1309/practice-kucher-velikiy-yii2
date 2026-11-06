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
                'only' => ['profile', 'favorites', 'watched', 'logout'],
                'rules' => [
                    [
                        'actions' => ['profile', 'favorites', 'watched', 'logout'],
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

    public function actionCatalog($genre_id = null)
    {
        $query = Movie::find()->with('genre');
        if ($genre_id !== null) {
            $query->andWhere(['genre_id' => $genre_id]);
        }

        $movies = $query->all();
        $activeGenre = $genre_id !== null ? Genre::findOne($genre_id) : null;

        return $this->render('catalog', [
            'movies' => $movies,
            'genreId' => $genre_id,
            'activeGenre' => $activeGenre,
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

    public function actionVotes()
    {
        return $this->render('votes');
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
        foreach (UserMovie::find()->where([
            'user_id' => Yii::$app->user->id,
            'movie_id' => $movieIds,
        ])->all() as $userMovie) {
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
