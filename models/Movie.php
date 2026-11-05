<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "movie".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $year
 * @property int|null $duration
 * @property string|null $poster_url
 */
class Movie extends ActiveRecord
{
    public static function tableName()
    {
        return 'movie';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['year', 'duration'], 'integer'],
            [['title', 'poster_url'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название фильма',
            'description' => 'Описание',
            'year' => 'Год',
            'duration' => 'Длительность',
            'poster_url' => 'Постер',
        ];
    }

    /**
     * Связь: у одного фильма много оценок/отзывов
     */
    public function getUserMovies()
    {
        return $this->hasMany(UserMovie::class, ['movie_id' => 'id']);
    }
}