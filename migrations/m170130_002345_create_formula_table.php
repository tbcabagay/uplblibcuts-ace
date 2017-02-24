<?php

use yii\db\Migration;

/**
 * Handles the creation of table `formula`.
 */
class m170130_002345_create_formula_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%formula}}', [
            'id' => $this->primaryKey(),
            'unit' => $this->string(10)->notNull(),
            'formula' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull(),
        ]);

        $this->addColumn('{{%service}}', 'formula', $this->integer()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%formula}}');

        $this->dropColumn('{{%service}}', 'formula');
    }
}
