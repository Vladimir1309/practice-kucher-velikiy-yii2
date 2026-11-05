<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string|null $nickname
 * @property string $email
 * @property string $password_hash
 * @property string|null $phone
 * @property string $created_at
 */
class User extends ActiveRecord implements IdentityInterface
{
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
            [['created_at'], 'safe'],
            [['username', 'nickname', 'email', 'password_hash'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'unique'],
        ];
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
            'email' => 'Email',
            'password_hash' => 'Хеш пароля',
            'phone' => 'Телефон',
            'created_at' => 'Дата регистрации',
        ];
    }

    /**
     * Связь: у одного пользователя много записей об оценках/фильмах
     */
    public function getUserMovies()
    {
        return $this->hasMany(UserMovie::class, ['user_id' => 'id']);
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