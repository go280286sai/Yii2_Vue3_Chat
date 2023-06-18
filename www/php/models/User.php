<?php

namespace app\models;

use app\functions\MyFunc;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord
{
    protected static object $user;

    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @param array $fields
     * @return bool|null
     * @throws \yii\base\Exception
     */
    public static function add(array $fields): null|bool
    {
        $fields = MyFunc::getFilds($fields);
        if (!self::find()->where(['email' => $fields['email']])->exists()) {
            $user = new self();
            $user->username = $fields['username'];
            $user->email = $fields['email'];
            $user->password = Yii::$app->security->generatePasswordHash($fields['password']);
            $user->authKey = Yii::$app->security->generateRandomString();
            $user->accessToken = Yii::$app->security->generateRandomString();
        } else {
            Yii::$app->session->setFlash('error', 'Пользователь с таким email уже существует');
            throw new \Exception('Пользователь с таким email уже существует');
        }
        Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались');
        return true;
    }

    public static function auth(array $fields): void
    {
        $fields = MyFunc::getFilds($fields);
        if (self::find()->where(['email' => $fields['email']])->exists()) {
            self::$user = self::find()->where(['email' => $fields['email']])->one();
            if (Yii::$app->security->validatePassword($fields['password'], self::$user->password)) {
                Yii::$app->session->set('user', self::$user);
            }else{
                Yii::$app->session->setFlash('error', 'Неверный пароль');
                throw new \Exception('Неверный пароль');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Пользователя с таким email не найдено');
            throw new \Exception('Пользователя с таким email не найдено');
        }
    }

    public static function last_activity(int $id): void
    {

        $user = self::find()->where(['id' => $id])->one();
        $user->last_activity=time();
        $user->save();
}
    public static function logout()
    {
        Yii::$app->session->remove('user');
}
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
