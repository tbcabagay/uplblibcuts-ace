<?php

use yii\db\Migration;

/**
 * Handles the creation of table `monitoring`.
 */
class m170117_021614_create_monitoring_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%session}}', [
            'id' => $this->char(40)->notNull(),
            'user' => $this->integer()->defaultValue(null),
            'ip_address' => $this->char(15)->notNull(),
            'expire' => $this->char(40)->defaultValue(null),
            'data' => 'LONGBLOB',
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
        $this->createTable('{{%monitor_login}}', [
            'id' => $this->bigPrimaryKey(),
            'user' => $this->integer()->notNull(),
            'time_in' =>  $this->integer()->notNull(),
            'time_out' =>  $this->integer()->notNull(),
            'last_ip' => $this->string(45)->notNull(),
        ], 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%session}}');
        $this->dropTable('{{%monitor_login}}');
    }
}
