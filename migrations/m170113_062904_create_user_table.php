<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170113_062904_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%library}}', [
            'id' => $this->primaryKey(),
            'location' => $this->string(50)->notNull(),
            'status' => $this->smallInteger()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'library' => $this->integer()->notNull(),
            'name' => $this->string(80)->notNull(),
            'username' => $this->string(60)->notNull(),
            'password_hash' => $this->char(60)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(32)->notNull(),
            'registration_ip' => $this->string(15),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%library}}');
        $this->dropTable('{{%user}}');
    }
}
