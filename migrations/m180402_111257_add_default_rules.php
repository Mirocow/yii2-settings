<?php

use yii\db\Migration;

/**
 * Class m180402_111257_add_default_rules
 */
class m180402_111257_add_default_rules extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $prefix = 'settings';

        $settings = [
            'Index' => 'Список настроек',
            'Create' => 'Создать настройку',
            'View' => 'Показать настройку',
            'Update' => 'Обновить настройку',
            'Delete' => 'Удалить настройку',
        ];

        foreach ($settings as $permission => $description) {
            $permit = Yii::$app->authManager->createPermission($prefix . $permission);
            $permit->description = $description;
            Yii::$app->authManager->add($permit);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180402_111257_add_default_rules cannot be reverted.\n";

        return false;
    }

}
