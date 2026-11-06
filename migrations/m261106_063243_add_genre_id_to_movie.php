<?php
use yii\db\Migration;

class m261106_063243_add_genre_id_to_movie extends Migration // Оставь имя класса как в твоем файле!
{
    public function safeUp()
    {
        // Добавляем колонку genre_id в таблицу movie
        $this->addColumn('{{%movie}}', 'genre_id', $this->integer()->null());

        // Создаем внешний ключ (связь)
        $this->addForeignKey(
            'fk-movie-genre_id',
            '{{%movie}}', 'genre_id',
            '{{%genre}}', 'id',
            'SET NULL' // Если жанр удалят, у фильма будет null
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-movie-genre_id', '{{%movie}}');
        $this->dropColumn('{{%movie}}', 'genre_id');
    }
}