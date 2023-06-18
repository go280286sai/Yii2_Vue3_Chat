<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $imageFile;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['username', 'password', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload()
    {
        if (isset($this->imageFile[0])) {
            $file = $this->imageFile[0];
            $image=Yii::$app->security->generateRandomString() . '.' . $file->extension;
            $file->saveAs('img/users/' . $image);
            $user = Yii::$app->session->get('user');
            if (file_exists('img/users/'.$user->image)) {
               unlink('img/users/'.$user->image);
            }
            $user->image=$image;
            $user->save();
            Yii::$app->session->set('user', $user);
                return true;
            } else {
                return false;
            }
        }

    /**
     * @param $user
     * @param $fields
     * @return void
     * @throws \yii\base\Exception
     */
    public function updateProfile($user, $fields)
    {
        if ($this->validate()) {
            if (!empty($fields['username'])) {
                $user->username = $fields['username'];
            }
            if (!empty($fields['email'])) {
                $user->email = $fields['email'];
            }
            if (!empty($fields['password'])) {
                $user->password = Yii::$app->security->generatePasswordHash( $fields['password']);
            }
            $user->save();
            Yii::$app->session->set('user', $user);
        }
    }
}