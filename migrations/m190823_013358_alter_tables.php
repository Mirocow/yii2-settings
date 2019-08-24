<?php

use yii\db\Migration;

/**
 * Class m190823_013358_alter_tables
 */
class m190823_013358_alter_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('key', 'settings');
        $this->createIndex('key', 'settings', ['key', 'group_name']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190823_013358_alter_tables cannot be reverted.\n";

        return false;
    }

}
