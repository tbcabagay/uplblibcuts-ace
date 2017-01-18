<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rent`.
 */
class m170117_010303_create_rent_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%pc}}', [
            'id' => $this->primaryKey(),
            'library' => $this->integer()->notNull(),
            'code' => $this->string(20)->notNull(),
            'ip_address' => $this->string(15),
            'status' => $this->smallInteger()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(30)->notNull(),
            'amount' => $this->money(5, 2)->notNull(),
            'status' => $this->smallInteger()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
        $this->createTable('{{%academic_year}}', [
            'id' => $this->bigPrimaryKey(),
            'semester' => $this->char(1)->notNull(),
            'date_start' => $this->date()->notNull(),
            'date_end' => $this->date()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
        $this->createTable('{{%rent}}', [
            'id' => $this->bigPrimaryKey(),
            'student' => $this->integer()->notNull(),
            'college' => $this->integer()->notNull(),
            'degree' => $this->integer()->notNull(),
            'pc' => $this->integer()->notNull(),
            'service' => $this->integer()->notNull(),
            'topic' => $this->string(30)->notNull(),
            'amount' => $this->money(5, 2)->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'time_in' => $this->integer()->notNull(),
            'time_out' => $this->integer()->notNull(),
            'rent_time' => $this->integer()->notNull(),
            'time_diff' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
        $this->createTable('{{%sale}}', [
            'id' => $this->primaryKey(),
            'library' => $this->integer()->notNull(),
            'student' => $this->char(10)->notNull(),
            'service' => $this->integer()->notNull(),
            'quantity' => $this->smallInteger()->notNull(),
            'amount' => $this->money(5, 2)->notNull(),
            'total' => $this->money(6, 2)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%pc}}');
        $this->dropTable('{{%service}}');
        $this->dropTable('{{%academic_year}}');
        $this->dropTable('{{%rent}}');
        $this->dropTable('{{%sale}}');
    }
}
