<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Movie;

/**
 * MovieSearch represents the model behind the search form of `app\models\Movie`.
 */
class MovieSearch extends Movie
{
    // Добавляем недостающие свойства, которые используются в catalog.php
    public $search;
    public $min_rating;
    public $sort;
    public $is_watched;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'year', 'duration', 'genre_id', 'min_rating'], 'integer'],
            [['title', 'description', 'poster_url', 'search', 'sort', 'is_watched'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Movie::find()->with('genre');

        // Присоединяем таблицу user_movie для фильтрации по просмотренным
        if (!Yii::$app->user->isGuest) {
            $query->leftJoin('user_movie um', 'um.movie_id = movie.id AND um.user_id = :userId', [':userId' => Yii::$app->user->id]);
        }

        $this->load($params);

        // Используем БЕЗ префиксов для ключей массива defaultOrder
        if ($this->sort === 'newest') {
            $defaultOrder = ['year' => SORT_DESC, 'id' => SORT_DESC];
        } elseif ($this->sort === 'title') {
            $defaultOrder = ['title' => SORT_ASC, 'id' => SORT_DESC];
        } else {
            $defaultOrder = ['id' => SORT_DESC];
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
            'sort' => [
                'defaultOrder' => $defaultOrder,
                // Явно маппим атрибуты на колонки с префиксом таблицы movie
                'attributes' => [
                    'id' => [
                        'asc' => ['movie.id' => SORT_ASC],
                        'desc' => ['movie.id' => SORT_DESC],
                    ],
                    'title' => [
                        'asc' => ['movie.title' => SORT_ASC],
                        'desc' => ['movie.title' => SORT_DESC],
                    ],
                    'year' => [
                        'asc' => ['movie.year' => SORT_ASC],
                        'desc' => ['movie.year' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Поиск по строке
        $query->andFilterWhere(['like', 'movie.title', $this->search]);

        // Фильтрация по остальным полям
        $query->andFilterWhere([
            'movie.id' => $this->id,
            'movie.year' => $this->year,
            'movie.duration' => $this->duration,
            'movie.genre_id' => $this->genre_id,
        ]);

        $query->andFilterWhere(['like', 'movie.description', $this->description])
              ->andFilterWhere(['like', 'movie.poster_url', $this->poster_url]);

        // Фильтр "Только просмотренные"
        if ($this->is_watched && !Yii::$app->user->isGuest) {
            $query->andWhere(['um.is_watched' => 1]);
        }

        return $dataProvider;
    }
}