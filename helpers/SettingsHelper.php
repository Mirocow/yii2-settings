<?php 

namespace mirocow\settings\helpers;

use mirocow\settings\models\Settings;
use yii\web\NotFoundHttpException;

class SettingsHelper
{

    /**
     * @param string $key
     * @param null $defaultValue
     * @return null
     */
    public static function get($key, $defaultValue = NULL)
    {
        $result = $defaultValue;

        if(is_object($model = static::findModel(['key' => $key]))){
            $result = $model->value;
        }

        return $result;
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     * @throws NotFoundHttpException
     */
    public static function set($key, $value)
    {
        if(!is_object($model = static::findModel(['key' => $key]))){
            throw new NotFoundHttpException('Настройка `' . $key . '` не найдена.');
        }

        $model->value = $value;

        return $model->save();
    }

    /**
     * @param string $key
     * @return null|static
     */
    protected static function findModel($key)
    {
        return Settings::findOne(['key' => $key]);
    }

}
