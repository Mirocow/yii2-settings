<?php

use yii\db\Migration;

/**
 * Class m180416_225252_alter_table_settings
 */
class m180416_225252_alter_table_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\mirocow\settings\models\Settings::tableName(), 'group_name', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180416_225252_alter_table_settings cannot be reverted.\n";

        return false;
    }

}
