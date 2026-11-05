<?php
namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $password_confirm;

    public function rules()
    {
        return [
            [['name', 'email', 'password', 'password_confirm'], 'required', 'message' => 'Заполните это поле.'],
            ['email', 'email', 'message' => 'Некорректный email.'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Этот email уже занят.'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6, 'message' => 'Пароль должен содержать минимум 6 символов.'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->name; // Берем имя из формы
        $user->email = $this->email;
        $user->setPassword($this->password); // Хешируем пароль
        $user->created_at = date('Y-m-d H:i:s');
        
        // По умолчанию никнейм и телефон пустые
        $user->nickname = null;
        $user->phone = null;

        return $user->save() ? $user : null;
    }
}