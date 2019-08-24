<?php 

namespace mirocow\settings\helpers;

use mirocow\settings\models\Settings;
use mirocow\settings\widgets\StringField;
use mirocow\settings\widgets\TextField;
use mirocow\settings\widgets\HTMLField;
use mirocow\settings\widgets\ArrayField;

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
