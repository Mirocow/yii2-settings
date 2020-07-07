<?php 

namespace mirocow\settings\helpers;

use mirocow\settings\models\Settings;
use yii\web\NotFoundHttpException;

class SettingsHelper
{

    /**
     * @param string $key
     * @param string $defaultValue
     * @param string $group_name   
     * @return string
     */
    public static function get($key, $defaultValue = NULL, $group_name = 'default')
    {
        $result = $defaultValue;

        if(is_object($model = static::findModel(['key' => $key, 'group_name' => $group_name]))){
            $result = $model->value;
        }

        return $result;
    }

    /**
     * @param string $key
     * @param string $value
     * @param string $group_name    
     * @return bool
     * @throws NotFoundHttpException
     */
    public static function set($key, $value, $group_name = 'default')
    {
        if(!is_object($model = static::findModel(['key' => $key, 'group_name' => $group_name]))){
            throw new NotFoundHttpException('Настройка `' . $key . '` не найдена.');
        }

        $model->value = $value;

        return $model->save();
    }

    /**
     * @param string $key
     * @param string $group_name     
     * @return null|static
     */
    protected static function findModel($key, $group_name = 'default')
    {
        return Settings::findOne(['key' => $key, 'group_name' => $group_name]);
    }

}
