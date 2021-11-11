<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * UpdatePassword form
 */
class UpdatePasswordForm extends Model
{
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password', 'compare'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'password_repeat' => '重复密码',
        ];
    }

    /**
     * Update user's password.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updatePassword()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findIdentity(Yii::$app->user->id);
        $user->setPassword($this->password);
        $user->updated_at = time();
        return $user->save() ? $user : null;
    }

    public function updatePasswordById($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findIdentity($id);
        $user->setPassword($this->password);
        $user->updated_at = time();
        return $user->save() ? $user : null;
    }
}
