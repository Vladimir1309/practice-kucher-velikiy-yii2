<?php

use yii\db\Migration;

class m261107_000000_add_avatar_to_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'avatar', $this->string(500)->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'avatar');
    }
}
