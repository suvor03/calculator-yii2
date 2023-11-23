<?php

namespace app\models;

use Yii;

class AuthForm extends User
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            $user = User::findByEmail($this->email);
            if ($user && $user->validatePassword($this->password)) {
                return Yii::$app->user->login($user);
            }
        }
        return false;
    }
}