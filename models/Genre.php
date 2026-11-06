<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Genre extends ActiveRecord
{
    public static function tableName()
    {
        return 'genre';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название жанра',
        ];
    }

    // СВЯЗЬ: У жанра много фильмов
    public function getMovies()
    {
        return $this->hasMany(Movie::class, ['genre_id' => 'id']);
    }
}
