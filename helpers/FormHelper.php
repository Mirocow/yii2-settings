<?php 

namespace mirocow\settings\helpers;

use settings\models\Settings;
use settings\widgets\StringField;
use settings\widgets\TextField;
use settings\widgets\HTMLField;
use settings\widgets\ArrayField;

class FormHelper
{

    protected static function fieldWidgets()
    {
        return [
            Settings::TYPE_STRING => StringField::className(),
            Settings::TYPE_TEXT => TextField::className(),
            Settings::TYPE_HTML => HTMLField::className(),
            Settings::TYPE_ARRAY => ArrayField::className(),
        ];
    }

    public static function getField($form, $model)
    {
        $fieldWidgets = static::fieldWidgets();
        $widgetClass = isset($fieldWidgets[$model->type]) ? $fieldWidgets[$model->type] : $fieldWidgets[Settings::TYPE_STRING];

        return $widgetClass::widget([
            'form' => $form,
            'model' => $model,
        ]);
    }

}
