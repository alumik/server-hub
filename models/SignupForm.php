<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $student_id;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'student_id'], 'trim'],
            [['student_id'], 'number'],
            [['username', 'student_id', 'password', 'password_repeat'], 'required'],
            [['username', 'student_id'], 'string', 'min' => 2, 'max' => 255],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['student_id', 'unique', 'targetClass' => '\app\models\User', 'message' => '账号已被使用。'],
            [['password'], 'compare'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'student_id' => '账号',
            'username' => '姓名',
            'password' => '密码',
            'password_repeat' => '重复密码',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->student_id = $this->student_id;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
}
