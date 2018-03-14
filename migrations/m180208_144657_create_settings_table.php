<?php 

use yii\db\Migration;

/**
 * Создание таблицы `settings`.
 */
class m180208_144657_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->tableExists()){
            $this->createTable(\settings\models\Settings::tableName(), [
                'id' => $this->primaryKey(),
                'key' => $this->string(50)->notNull()->unique(),
                'name' => $this->string(255)->null(),
                'value' => $this->db->schema->createColumnSchemaBuilder('LONGTEXT')->null(),
                'type' => $this->db->schema->createColumnSchemaBuilder('TINYINT', 1)->notNull()->defaultValue(1),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->tableExists() AND $this->dropTable(\settings\models\Settings::tableName());
    }

    protected function tableExists()
    {
        return !is_null($this->db->schema->getTableSchema(\settings\models\Settings::tableName()));
    }

}
