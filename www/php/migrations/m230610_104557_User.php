<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m230610_104557_User
 */
class m230610_104557_User extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'username' => $this->string('255')->null(),
            'password' => $this->string('255')->notNull(),
            'accessToken' => $this->string('255')->null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'authKey' => $this->string('100')->null(),
            'image' => $this->string('255')->defaultValue('no-name.png'),
            'authorizationCode' => $this->string('255')->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
            'last_activity' => $this->time()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230610_104557_User cannot be reverted.\n";

        return false;
    }
    */
}
