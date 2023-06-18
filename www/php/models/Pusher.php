<?php

namespace app\models;

use Pusher\Pusher as Push;

class Pusher
{
    private const app_id = "1616601";
    private const key = "75f4b0fe93296de23495";
    private const secret = "c22c5a05ff5e985879f5";
    private const options = ['cluster' => 'eu', 'useTLS' => true];

    private static ?object $instance = null;

    private function __construct()
    {
    }

    private function __clone(): void
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance(): ?object
    {
        if (self::$instance === null) {
            self::$instance = new Push(
                self::key,
                self::secret,
                self::app_id,
                self::options
            );
        }
        return self::$instance;
    }

    public static function send(string $message = 'test'): void
    {   \Yii::$app->redis->rpush('my-channel:my-event:string', $message);
        self::getInstance()->trigger('my-channel', 'my-event', $message);
    }

}