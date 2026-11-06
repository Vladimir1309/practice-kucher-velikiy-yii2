<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "movie".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $year
 * @property int|null $duration
 * @property string|null $poster_url
 * @property int|null $genre_id
 *
 * @property Genre $genre
 * @property UserMovie[] $userMovies
 */
class Movie extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movie';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['year', 'duration', 'genre_id'], 'integer'],
            [['title', 'poster_url'], 'string', 'max' => 255],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::className(), 'targetAttribute' => ['genre_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название фильма',
            'description' => 'Описание',
            'year' => 'Год выпуска',
            'duration' => 'Длительность (мин)',
            'poster_url' => 'Ссылка на постер',
            'genre_id' => 'Жанр',
        ];
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genre_id']);
    }

    /**
     * Gets query for [[UserMovies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserMovies()
    {
        return $this->hasMany(UserMovie::className(), ['movie_id' => 'id']);
    }
}
