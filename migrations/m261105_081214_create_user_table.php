<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m261105_081214_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'nickname' => $this->string(255),
            'email' => $this->string(255)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'phone' => $this->string(20),
            'created_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}