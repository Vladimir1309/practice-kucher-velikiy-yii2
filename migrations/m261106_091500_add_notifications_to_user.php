<?php

use yii\db\Migration;

/**
 * Adds notification preferences to the user table.
 */
class m261106_091500_add_notifications_to_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'notify_news', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('{{%user}}', 'notify_reminders', $this->boolean()->notNull()->defaultValue(false));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'notify_reminders');
        $this->dropColumn('{{%user}}', 'notify_news');
    }
}
