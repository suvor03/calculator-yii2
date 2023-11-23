<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
	public $username;
	public $email;
	public $password;
	public $password_repeat;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			[['username', 'email', 'password', 'password_repeat'], 'required'],
			['username', 'match', 'pattern' => '/^[A-Za-zА-Яа-я]+$/u', 'message' => 'Только буквы A-z или А-я, в любом регистре'],
			['email', 'email'],
			['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот адрес электронной почты уже занят.'],
			['password', 'match', 'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', 'message' => 'Пароль должен содержать буквы A-z и цифры (минимум 8 символов)'],
			['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
		];
	}

	public function register()
	{
		 if ($this->validate()) {
			  $user = new User();
			  $user->username = $this->username;
			  $user->email = $this->email;
			  $user->setPassword($this->password);
			  $user->generateAuthKey();
			  if ($user->save()) {
					return true;
			  }
		 }
		 return false;
	}
}