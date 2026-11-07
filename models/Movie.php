<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

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
    public $imageFile;

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
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2, 'checkExtensionByMimeType' => false],
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
            'imageFile' => 'Постер фильма',
            'genre_id' => 'Жанр',
        ];
    }

    public function upload()
    {
        if ($this->imageFile === null || !$this->imageFile instanceof UploadedFile) {
            return false;
        }

        $directory = Yii::getAlias('@webroot/uploads/posters/');
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            return false;
        }

        $filename = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
        if (!$this->imageFile->saveAs($directory . $filename)) {
            return false;
        }

        $this->poster_url = '/uploads/posters/' . $filename;
        return true;
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
