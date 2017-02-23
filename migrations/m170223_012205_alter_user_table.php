<?php

use yii\db\Migration;

class m170223_012205_alter_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'timezone', $this->string(40)->notNull());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'timezone');
    }
}
