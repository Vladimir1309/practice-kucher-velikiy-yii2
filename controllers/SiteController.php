<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\ForbiddenHttpException;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Movie;
use app\models\Genre;
use app\models\UserMovie;
use app\models\User;
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
                'only' => ['logout', 'profile', 'votes', 'favorites', 'watched', 'settings', 'delete-review', 'admin'],
                'rules' => [
                    [
                        'actions' => ['logout', 'profile', 'votes', 'favorites', 'watched', 'settings', 'delete-review'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['admin'],
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
        $genres = Genre::find()
            ->select(['genre.*', 'COUNT(movie.id) AS movieCount'])
            ->leftJoin('movie', 'movie.genre_id = genre.id')
            ->groupBy('genre.id')
            ->all();

        return $this->render('index', [
            'movies' => $movies,
            'genres' => $genres,
            'movieStates' => $this->getMovieStates($movies),
        ]);
    }

    // public function actionDownloadPosters()
    // {
    //     // TODO: Remove this action after running once in production.
    //     $directory = Yii::getAlias('@webroot/uploads/posters/');
    //     if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
    //         echo "Unable to create poster directory: {$directory}<br>\n";
    //         return;
    //     }

    //     $movies = Movie::find()->all();
    //     $context = stream_context_create([
    //         'http' => [
    //             'timeout' => 20,
    //             'follow_location' => true,
    //             'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    //         ],
    //         'ssl' => [
    //             'verify_peer' => false,
    //             'verify_peer_name' => false,
    //         ],
    //     ]);

    //     foreach ($movies as $movie) {
    //         if (!is_string($movie->poster_url) || !preg_match('/^https?:\/\//i', $movie->poster_url)) {
    //             echo "Skipped: {$movie->title}<br>\n";
    //             continue;
    //         }

    //         $contents = @file_get_contents($movie->poster_url, false, $context);
    //         if ($contents === false && function_exists('curl_init')) {
    //             $curl = curl_init($movie->poster_url);
    //             curl_setopt_array($curl, [
    //                 CURLOPT_RETURNTRANSFER => true,
    //                 CURLOPT_FOLLOWLOCATION => true,
    //                 CURLOPT_MAXREDIRS => 5,
    //                 CURLOPT_CONNECTTIMEOUT => 10,
    //                 CURLOPT_TIMEOUT => 20,
    //                 CURLOPT_SSL_VERIFYPEER => false,
    //                 CURLOPT_SSL_VERIFYHOST => false,
    //                 CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    //             ]);
    //             $curlContents = curl_exec($curl);
    //             $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //             curl_close($curl);

    //             if ($curlContents !== false && $httpCode >= 200 && $httpCode < 300) {
    //                 $contents = $curlContents;
    //             }
    //         }

    //         if ($contents === false) {
    //             echo "Failed to download: {$movie->title}<br>\n";
    //             continue;
    //         }

    //         $filename = 'poster_' . $movie->id . '.jpg';
    //         $path = $directory . $filename;
    //         if (file_put_contents($path, $contents) === false) {
    //             echo "Failed to save: {$movie->title}<br>\n";
    //             continue;
    //         }

    //         $movie->poster_url = '/uploads/posters/' . $filename;
    //         if (!$movie->save(false, ['poster_url'])) {
    //             echo "Failed to update database: {$movie->title}<br>\n";
    //             continue;
    //         }

    //         echo "Downloaded: {$movie->title}<br>\n";
    //     }
    // }

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
        if (Yii::$app->request->isPost) {
            if ($user->load(Yii::$app->request->post())) {
                $user->imageFile = UploadedFile::getInstance($user, 'imageFile');
                $uploadValid = $user->imageFile === null || $user->validate(['imageFile']);
                $uploadSaved = $user->imageFile === null;
                if ($uploadValid && $user->imageFile !== null) {
                    $uploadSaved = $user->upload();
                    if (!$uploadSaved && !$user->hasErrors('imageFile')) {
                        $user->addError('imageFile', 'Не удалось сохранить файл аватара.');
                    }
                }
                if ($uploadValid && $uploadSaved && $user->save()) {
                    Yii::$app->session->setFlash('success', 'Профиль успешно обновлен.');
                    return $this->refresh();
                }

                $errors = $user->getErrors();
                $user->refresh();
                foreach ($errors as $attribute => $messages) {
                    foreach ($messages as $message) {
                        $user->addError($attribute, $message);
                    }
                }
            }
        }

        return $this->render('profile', [
            'user' => $user,
        ]);
    }

    public function actionAdmin()
    {
        if (
            Yii::$app->user->identity->role === null
            || Yii::$app->user->identity->role->name !== 'admin'
        ) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }

        return $this->render('admin', [
            'users' => User::find()->orderBy(['id' => SORT_ASC])->all(),
        ]);
    }

    public function actionSettings()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;
        if (Yii::$app->request->isPost) {
            $form = Yii::$app->request->post('settings_form');
            if ($form === 'notifications') {
                $user->notify_news = (int) Yii::$app->request->post('notify_news', 0) === 1;
                $user->notify_reminders = (int) Yii::$app->request->post('notify_reminders', 0) === 1;
                if ($user->save(false, ['notify_news', 'notify_reminders'])) {
                    Yii::$app->session->setFlash('success', 'Настройки уведомлений сохранены.');
                } else {
                    Yii::$app->session->setFlash('error', 'Не удалось сохранить настройки уведомлений.');
                }
            } elseif ($form === 'password') {
                $currentPassword = (string) Yii::$app->request->post('current_password', '');
                $newPassword = (string) Yii::$app->request->post('new_password', '');
                $confirmPassword = (string) Yii::$app->request->post('confirm_password', '');

                if (!$user->validatePassword($currentPassword)) {
                    Yii::$app->session->setFlash('error', 'Текущий пароль указан неверно.');
                } elseif (strlen($newPassword) < 6) {
                    Yii::$app->session->setFlash('error', 'Новый пароль должен содержать минимум 6 символов.');
                } elseif ($newPassword !== $confirmPassword) {
                    Yii::$app->session->setFlash('error', 'Пароли не совпадают.');
                } else {
                    $user->setPassword($newPassword);
                    if ($user->save(false, ['password_hash'])) {
                        Yii::$app->session->setFlash('success', 'Пароль успешно изменен.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Не удалось изменить пароль.');
                    }
                }
            }

            return $this->redirect(['site/settings']);
        }

        return $this->render('settings', ['user' => $user]);
    }

    public function actionVotes($movie_id = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        if (Yii::$app->request->isPost) {
            $movieId = Yii::$app->request->post('movie_id');
            $reviewId = Yii::$app->request->post('review_id');
            if (!$reviewId) {
                $exists = UserMovie::find()
                    ->where([
                        'user_id' => Yii::$app->user->id,
                        'movie_id' => $movieId,
                    ])
                    ->andWhere(['is not', 'rating', null])
                    ->exists();
                if ($exists) {
                    Yii::$app->session->setFlash('error', 'Вы уже оставили отзыв на этот фильм. Отредактируйте его в списке ниже.');
                    return $this->redirect(['site/votes']);
                }
            }

            $movie = Movie::findOne($movieId);
            if ($movie === null) {
                throw new NotFoundHttpException('Фильм не найден.');
            }

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

        $review->rating = null;
        $review->comment = null;
        if (!$review->is_favorite && !$review->is_watched) {
            $deleted = $review->delete();
        } else {
            $deleted = $review->save(false);
        }

        if ($deleted === false) {
            Yii::$app->session->setFlash('error', 'Не удалось удалить отзыв.');
        } else {
            Yii::$app->session->setFlash('success', 'Отзыв удален.');
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
