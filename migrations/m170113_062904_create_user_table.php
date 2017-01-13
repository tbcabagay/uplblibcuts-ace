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
        ]);
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'library_id' => $this->integer()->notNull(),
            'name' => $this->string(80)->notNull(),
            'username' => $this->string(60)->notNull(),
            'password_hash' => $this->char(60)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'registration_ip' => $this->string(45),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-user-library_id-library-id', '{{%user}}', 'library_id', '{{%library}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-user-library_id-library-id', '{{%user}}');

        $this->dropTable('{{%library}}');
        $this->dropTable('{{%user}}');
    }
}
