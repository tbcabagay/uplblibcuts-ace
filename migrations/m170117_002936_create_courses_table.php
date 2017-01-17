<?php

use yii\db\Migration;

/**
 * Handles the creation of table `courses`.
 */
class m170117_002936_create_courses_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%college}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(10)->notNull(),
            'description' => $this->string(50)->notNull(),
            'status' => $this->smallInteger()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');

        $this->createTable('{{%degree}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(15)->notNull(),
            'description' => $this->string(50)->notNull(),
            'status' => $this->smallInteger()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%college}}');
        $this->dropTable('{{%degree}}');
    }
}
