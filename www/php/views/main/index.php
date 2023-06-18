<?php

use app\models\User;

?>

<div class="container">
    <div class="row">
        <div id="app">

            <div class="container chat-container">
                <div class="row">
                    <div class="row body-form">
                        <div class="col-12 body-text" id="body-text">
                            <div v-for="message in messages">
                                <div v-if="message.id === my_id">
                                    <div class="text-my">
                                        <div class="message-user">{{ message.name }}</div>
                                        <div class="message-text">{{ message.message }}</div>
                                        <div class="message-time">{{ message.date }}</div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="text-other">
                                        <div class="message-user">{{ message.name }}</div>
                                        <div class="message-text">{{ message.message }}</div>
                                        <div class="message-time">{{ message.date }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row body-button">
                        <div class="col body-button-text">
                <textarea class="textarea-send" name="message" id="message" placeholder="Введите сообщение"
                          v-model="text"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="btn-chat" v-on:click="sendMessage">Отправить</div>
                    </div>
                    <div class="row">
                        <div class="body-form">
                            <div class="body-contact">
                                <?php $onlineUsers = User::find()->orderBy('last_activity DESC')->all();

                                foreach ($onlineUsers as $onlineUser) {
                                    if ($onlineUser->last_activity >= time() - 300 && $onlineUser->last_activity > 1) {
                                        echo '<div class="online-user">'. $onlineUser->username . ' <small class="small-online">on-line</small></div>';
                                    } else{
                                        echo '<div class="offline-user">'. $onlineUser->username . ' <small class="small-offline">off-line</small></div>';
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://unpkg.com/vue@next"></script>
<script>
    Pusher.logToConsole = true;
    const pusher = new Pusher("<?= \Yii::$app->params['push_app_key'] ?>", {
        cluster: "<?= \Yii::$app->params['push_app_cluster'] ?>"
    });
    const channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function (data) {
        app.messages.push(JSON.parse(data));
        setTimeout(() => {
            const div = document.getElementById('body-text');
            div.scrollTop = div.scrollHeight;
        }, 1000);
    });

    const app = Vue.createApp({
        data() {
            return {
                status: 0,
                text: '',
                my_id: "<?= $user->id ?? '' ?>",
                messages: [],
            }
        },
        methods: {
            sendMessage() {
                let username = "<?= $user->username ?? '' ?>";
                let message = this.text;
                let id = this.my_id;
                let date = new Date();
                let csfr = "<?= Yii::$app->request->getCsrfToken() ?>";
                $.ajax(
                    {
                        url: "<?= Yii::$app->request->baseUrl . '/chat/pusher' ?>",
                        type: 'POST',
                        data: {
                            body: {
                                id: id,
                                name: username,
                                message: message,
                                date: date
                            }, _csfr: csfr
                        },
                        success: function () {
                            console.log('200');
                        },
                        error: function (err) {
                            console.log(err.message);
                        }
                    }
                );
                this.text = '';


            }
        }
    }).mount('#app');
</script>
<script>
    if (app.status === 0) {
        const data = <?= Yii::$app->redis->exists('my-channel:my-event:string') ?>;
        if(data !== 0){
            <?php
             $res =   Yii::$app->redis->lrange('my-channel:my-event:string', 0, -1);
             foreach ($res as $item) {
                echo 'app.messages.push(' . $item . ');';
             }
            ?>
            console.log(app.messages);
        }
        app.status = 1;
    }
    console.log(app.status);
</script>