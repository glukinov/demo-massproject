<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 */
class m250213_115800_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'message' => $this->text()->notNull(),
            'comment' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request}}');
    }
}
