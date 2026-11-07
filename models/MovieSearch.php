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
    public $sort;
    public $is_watched;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'year', 'duration', 'genre_id'], 'integer'],
            [['title', 'description', 'poster_url', 'sort', 'is_watched'], 'safe'],
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
        $query = Movie::find()->alias('movie');

        $this->load($params);

        if (!Yii::$app->user->isGuest) {
            $query->leftJoin(
                'user_movie um',
                'um.movie_id = movie.id AND um.user_id = :userId',
                [':userId' => Yii::$app->user->id]
            );
        } else {
            $query->leftJoin('user_movie um', 'um.movie_id = movie.id');
        }

        if ($this->sort === 'newest') {
            $defaultOrder = ['year' => SORT_DESC, 'id' => SORT_DESC];
        } elseif ($this->sort === 'title') {
            $defaultOrder = ['title' => SORT_ASC, 'id' => SORT_DESC];
        } else {
            $defaultOrder = ['id' => SORT_DESC];
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => $defaultOrder,
                'attributes' => [
                    'id' => ['asc' => ['movie.id' => SORT_ASC], 'desc' => ['movie.id' => SORT_DESC]],
                    'title' => ['asc' => ['movie.title' => SORT_ASC], 'desc' => ['movie.title' => SORT_DESC]],
                    'year' => ['asc' => ['movie.year' => SORT_ASC], 'desc' => ['movie.year' => SORT_DESC]],
                ],
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'movie.id' => $this->id,
            'movie.year' => $this->year,
            'movie.duration' => $this->duration,
            'movie.genre_id' => $this->genre_id,
        ]);

        $query->andFilterWhere(['like', 'movie.title', $this->title])
            ->andFilterWhere(['like', 'movie.description', $this->description])
            ->andFilterWhere(['like', 'movie.poster_url', $this->poster_url]);

        if ($this->is_watched) {
            $query->andWhere(['um.is_watched' => 1]);
        }

        return $dataProvider;
    }
}
