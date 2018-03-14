<?php 

use yii\db\Migration;

/**
 * Создание таблицы `settings`.
 */
class m180208_144657_create_settings_table extends Migration
{

    protected $tableName = 'settings';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(!$this->tableExists()){
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'name' => $this->string(50)->notNull()->unique(),
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
        $this->tableExists() AND $this->dropTable($this->tableName);
    }

    protected function tableExists()
    {
        return !is_null($this->db->schema->getTableSchema($this->tableName));
    }

}
