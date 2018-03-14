<?php 

namespace settings\helpers;

use settings\models\Settings;
use yii\web\NotFoundHttpException;

class SettingsHelper
{

    public static function get($id, $defaultValue = NULL)
    {
        $result = $defaultValue;

        if(is_object($model = static::findModel($id))){
            $result = $model->value;
        }

        return $result;
    }

    public static function set($id, $value)
    {
        if(!is_object($model = static::findModel($id))){
            throw new NotFoundHttpException('Настройка `' . $id . '` не найдена.');
        }

        $model->value = $value;

        return $model->save();
    }

    protected static function findModel($id)
    {
        return Settings::findOne($id);
    }

}
