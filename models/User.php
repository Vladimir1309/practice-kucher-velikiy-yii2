<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string|null $nickname
 * @property string|null $last_name
 * @property string|null $birthdate
 * @property string $email
 * @property string $password_hash
 * @property string|null $phone
 * @property bool $notify_news
 * @property bool $notify_reminders
 * @property int $role_id
 * @property string|null $avatar
 * @property string $created_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'created_at'], 'required'],
            [['created_at', 'birthdate'], 'safe'],
            [['birthdate'], 'date', 'format' => 'php:Y-m-d'],
            [['notify_news', 'notify_reminders'], 'boolean'],
            [['notify_news', 'notify_reminders'], 'safe'],
            [['username', 'nickname', 'email', 'password_hash'], 'string', 'max' => 255],
            [['last_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['role_id'], 'integer'],
            [['role_id'], 'safe'],
            [['avatar'], 'string', 'max' => 500],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2, 'checkExtensionByMimeType' => false],
            [['email'], 'email'],
            [['email'], 'unique', 'filter' => function ($query) {
                $query->andWhere(['!=', 'id', $this->id]);
            }],
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        $this->username = trim((string) $this->username);
        $this->email = trim((string) $this->email);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя',
            'nickname' => 'Никнейм',
            'last_name' => 'Фамилия',
            'birthdate' => 'Дата рождения',
            'email' => 'Email',
            'password_hash' => 'Хеш пароля',
            'phone' => 'Телефон',
            'role_id' => 'Роль',
            'avatar' => 'Аватар',
            'imageFile' => 'Изменить фото',
            'created_at' => 'Дата регистрации',
            'notify_news' => 'Новости CineNight',
            'notify_reminders' => 'Напоминания',
        ];
    }

    public function upload()
    {
        if ($this->imageFile === null || !$this->imageFile instanceof UploadedFile) {
            return false;
        }

        $directory = Yii::getAlias('@webroot/uploads/avatars/');
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            return false;
        }

        $filename = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
        $path = $directory . $filename;
        if (!$this->imageFile->saveAs($path)) {
            return false;
        }

        $this->avatar = '/uploads/avatars/' . $filename;
        return true;
    }

    /**
     * Связь: у одного пользователя много записей об оценках/фильмах
     */
    public function getUserMovies()
    {
        return $this->hasMany(UserMovie::class, ['user_id' => 'id']);
    }

    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    // ==========================================
    // МЕТОДЫ ДЛЯ АВТОРИЗАЦИИ (IdentityInterface)
    // ==========================================

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; 
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->password_hash; 
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}