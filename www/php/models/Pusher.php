<?php

namespace app\models;

use Pusher\Pusher as Push;

class Pusher
{
    private const app_id = "";
    private const key = "";
    private const secret = "";
    private const options = ['cluster' => 'eu', 'useTLS' => true];

    /**
     * @var object|null
     */
    private static ?object $instance = null;

    private function __construct()
    {
    }

    private function __clone(): void
    {
        // TODO: Implement __clone() method.
    }

    /**
     * @return object|Push|null
     */
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

    /**
     * @param string $message
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Pusher\ApiErrorException
     * @throws \Pusher\PusherException
     */
    public static function send(string $message = 'test'): void
    {   \Yii::$app->redis->rpush('my-channel:my-event:string', $message);
        self::getInstance()->trigger('my-channel', 'my-event', $message);
    }

}