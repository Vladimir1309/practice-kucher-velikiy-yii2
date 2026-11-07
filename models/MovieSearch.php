<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MovieSearch extends Movie
{
    public $search;
    public $min_rating;
    public $sort;
    public $is_watched;

    public function rules()
    {
        return [
            [['id', 'year', 'duration', 'genre_id', 'min_rating'], 'integer'],
            [['title', 'description', 'poster_url', 'search', 'sort', 'is_watched'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Movie::find()->alias('movie')->with('genre');

        if (!Yii::$app->user->isGuest) {
            $query->leftJoin(
                'user_movie um',
                'um.movie_id = movie.id AND um.user_id = :userId',
                [':userId' => Yii::$app->user->id]
            );
        }

        $this->load($params);

        if ($this->sort === 'newest') {
            $defaultOrder = ['year' => SORT_DESC, 'id' => SORT_DESC];
        } elseif ($this->sort === 'title') {
            $defaultOrder = ['title' => SORT_ASC, 'id' => SORT_DESC];
        } else {
            $defaultOrder = ['id' => SORT_DESC];
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 12],
            'sort' => [
                'defaultOrder' => $defaultOrder,
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

        $query->andFilterWhere(['like', 'movie.title', $this->search])
            ->andFilterWhere([
                'movie.id' => $this->id,
                'movie.year' => $this->year,
                'movie.duration' => $this->duration,
                'movie.genre_id' => $this->genre_id,
            ])
            ->andFilterWhere(['like', 'movie.description', $this->description])
            ->andFilterWhere(['like', 'movie.poster_url', $this->poster_url]);

        if ($this->is_watched && !Yii::$app->user->isGuest) {
            $query->andWhere(['um.is_watched' => 1]);
        }

        return $dataProvider;
    }
}
