<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * @property-read User|null $user This property is read-only.
 */
class LoginForm extends Model
{
    public $student_id;
    public $password;

    private $_user = false;

    public function rules()
    {
        return [
            // student_id and password are both required
            [['student_id', 'password'], 'required'],
            // password is validated by validatePassword()
            [['password'], 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'student_id' => '账号',
            'password' => '密码',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '账号或密码不正确。');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 3600 * 24 * 30);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByStudentId($this->student_id);
        }

        return $this->_user;
    }
}
