<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%movie}}`.
 */
class m261105_080704_create_movie_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%movie}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(), // Название фильма
            'description' => $this->text(),           // Описание
            'year' => $this->integer(),               // Год выпуска
            'duration' => $this->integer(),           // Длительность в минутах
            'poster_url' => $this->string(255),       // Путь к картинке
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%movie}}');
    }
}