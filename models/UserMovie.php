<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_movie".
 *
 * @property int $id
 * @property int $user_id
 * @property int $movie_id
 * @property int|null $rating
 * @property string|null $comment
 * @property int $is_favorite
 * @property int $is_watched
 * @property string $created_at
 */
class UserMovie extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_movie';
    }

    public function rules()
    {
        return [
            [['user_id', 'movie_id', 'created_at'], 'required'],
            [['user_id', 'movie_id', 'rating'], 'integer'],
            [['comment'], 'string'],
            [['is_favorite', 'is_watched'], 'boolean'],
            [['created_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'movie_id' => 'Фильм',
            'rating' => 'Оценка',
            'comment' => 'Комментарий',
            'is_favorite' => 'В избранном',
            'is_watched' => 'Просмотрено',
            'created_at' => 'Дата',
        ];
    }

    /**
     * Связь: запись принадлежит одному пользователю
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Связь: запись принадлежит одному фильму
     */
    public function getMovie()
    {
        return $this->hasOne(Movie::class, ['id' => 'movie_id']);
    }
}