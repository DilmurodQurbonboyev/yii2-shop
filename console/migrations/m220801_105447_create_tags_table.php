<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tags}}`.
 */
class m220801_105447_create_tags_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            '{{%idx-shop_tags-slug}}',
            '{{%shop_tags}}',
            'slug',
            true
        );
    }

    public function down()
    {
        $this->dropTable('{{%shop_tags}}');
    }
}
