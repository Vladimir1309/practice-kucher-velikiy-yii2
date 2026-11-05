<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_movie}}`.
 */
class m261105_081601_create_user_movie_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_movie}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'movie_id' => $this->integer()->notNull(),
            'rating' => $this->integer()->defaultValue(null),
            'comment' => $this->text()->defaultValue(null),
            'is_favorite' => $this->boolean()->defaultValue(false),
            'is_watched' => $this->boolean()->defaultValue(false),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        // Создаем внешние ключи для связи с таблицами user и movie
        $this->addForeignKey(
            'fk-user_movie-user_id',
            '{{%user_movie}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE' // При удалении пользователя удалятся его оценки
        );

        $this->addForeignKey(
            'fk-user_movie-movie_id',
            '{{%user_movie}}', 'movie_id',
            '{{%movie}}', 'id',
            'CASCADE' // При удалении фильма удалятся его оценки
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Сначала удаляем ключи, иначе база данных не даст удалить таблицу
        $this->dropForeignKey('fk-user_movie-user_id', '{{%user_movie}}');
        $this->dropForeignKey('fk-user_movie-movie_id', '{{%user_movie}}');
        $this->dropTable('{{%user_movie}}');
    }
}