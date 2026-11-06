<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\db\Expression;

class MovieSearch extends Movie
{
    public $search;
    public $genre_id;
    public $min_rating;
    public $is_watched;
    public $sort;

    public function rules()
    {
        return [
            [['search', 'sort'], 'string'],
            [['genre_id', 'is_watched'], 'integer'],
            [['min_rating'], 'number'],
        ];
    }

    public function search($params)
    {
        $this->load($params);

        $query = Movie::find()
            ->alias('movie')
            ->with('genre')
            ->leftJoin(['um' => 'user_movie'], 'um.movie_id = movie.id')
            ->groupBy('movie.id');

        $query->andFilterWhere(['like', 'movie.title', $this->search]);
        $query->andFilterWhere(['movie.genre_id' => $this->genre_id]);

        if ($this->min_rating !== null && $this->min_rating !== '') {
            $query->having(['>=', new Expression('AVG(um.rating)'), $this->min_rating]);
        }

        if ((int) $this->is_watched === 1) {
            if (Yii::$app->user->isGuest) {
                $query->andWhere('1 = 0');
            } else {
                $query->andWhere([
                    'um.user_id' => Yii::$app->user->id,
                    'um.is_watched' => 1,
                ]);
            }
        }

        switch ($this->sort) {
            case 'newest':
                $query->orderBy(['movie.year' => SORT_DESC, 'movie.id' => SORT_DESC]);
                break;
            case 'title':
                $query->orderBy(['movie.title' => SORT_ASC]);
                break;
            case 'popular':
            default:
                $query->addSelect(['movie.*', 'average_rating' => 'AVG(um.rating)']);
                $query->orderBy(['average_rating' => SORT_DESC, 'movie.id' => SORT_DESC]);
                break;
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
            'sort' => new Sort([
                'attributes' => [
                    'id',
                    'title',
                    'rating' => [
                        'asc' => ['average_rating' => SORT_ASC],
                        'desc' => ['average_rating' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['rating' => SORT_DESC],
            ]),
        ]);
    }
}
