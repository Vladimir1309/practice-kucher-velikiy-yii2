<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Movie;

/**
 * MovieSearch represents the model behind the search form of `app\models\Movie`.
 */
class MovieSearch extends Movie
{
    public $sort;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'year', 'duration', 'genre_id'], 'integer'],
            [['title', 'description', 'poster_url', 'sort'], 'safe'],
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
        $query = Movie::find();

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
            'sort' => [
                'defaultOrder' => $defaultOrder,
                'attributes' => [
                    'id',
                    'title',
                    'year',
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
            'id' => $this->id,
            'year' => $this->year,
            'duration' => $this->duration,
            'genre_id' => $this->genre_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'poster_url', $this->poster_url]);

        return $dataProvider;
    }
}
