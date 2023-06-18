<?php

use yii\db\Migration;

/**
 * Class m230614_134114_sessionMigrate
 */
class m230614_134114_sessionMigrate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('session', [
            'id' => $this->string(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('session');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230614_134114_sessionMigrate cannot be reverted.\n";

        return false;
    }
    */
}
