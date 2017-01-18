<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student`.
 */
class m170117_004352_create_student_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%student}}', [
            'id' => $this->primaryKey(),
            'number' => $this->char(10)->notNull(),
            'firstname' => $this->string(40)->notNull(),
            'middlename' => $this->string(40)->notNull(),
            'lastname' => $this->string(10)->notNull(),
            'sex' => $this->char(1)->notNull(),
            'degree' => $this->integer()->notNull(),
            'college' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'rent_time' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%student}}');
    }
}
