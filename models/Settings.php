<?php

namespace settings\models;

use yii\db\ActiveRecord;
use settings\widgets\StringField;
use settings\widgets\TextField;
use settings\widgets\HTMLField;
use settings\widgets\SwitchField;
use settings\widgets\DateTimeField;
use settings\widgets\ArrayField;

class Settings extends ActiveRecord
{

    const TYPE_STRING = 1;
    const TYPE_TEXT = 2;
    const TYPE_HTML = 3;
    const TYPE_SWITCH = 4;
    const TYPE_DATE_TIME = 5;
    const TYPE_ARRAY = 6;

    public static function tableName()
    {
        return 'settings';
    }

    public function rules()
    {
        return [
            [['key', 'type'], 'required'],
            [['key', 'name'], 'trim'],
            [['key'], 'match', 'pattern' => '/^[a-z_.]*$/i', 'message' => 'Машинное имя может содержать только латинские буквы и символ подчеркивания и знак группировки .'],
            [['type'], 'integer'],
            [['type'], 'in', 'range' => array_keys($this->getTypeList())],
            [['type'], 'default', 'value' => static::TYPE_STRING],
            [['name', 'value'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Машинное наименование',
            'name' => 'Наименование',
            'value' => 'Значение',
            'type' => 'Тип',
        ];
    }

    public function getTypeList()
    {
        return [
            static::TYPE_STRING => 'Строка',
            static::TYPE_TEXT => 'Текст',
            static::TYPE_HTML => 'HTML',
            static::TYPE_SWITCH => 'Чекбокс',
            static::TYPE_DATE_TIME => 'Дата',
            static::TYPE_ARRAY => 'Массив',
        ];
    }

    public function getTypeName()
    {
        $typeList = $this->getTypeList();
        return isset($typeList[$this->type]) ? $typeList[$this->type] : NULL;
    }

    public function getTypeWidgetList()
    {
        return [
            static::TYPE_STRING => StringField::className(),
            static::TYPE_TEXT => TextField::className(),
            static::TYPE_HTML => HTMLField::className(),
            static::TYPE_SWITCH => SwitchField::className(),
            static::TYPE_DATE_TIME => DateTimeField::className(),
            static::TYPE_ARRAY => ArrayField::className(),
        ];
    }

    public function getTypeWidgetClassName()
    {
        $typeWidgetList = $this->getTypeWidgetList();
        return isset($typeWidgetList[$this->type]) ? $typeWidgetList[$this->type] : NULL;
    }

    public function getTypeWidget($view, $form)
    {
        if(!is_null($C = $this->typeWidgetClassName)){
            return $C::widget([
                'view' => $view,
                'form' => $form,
                'model' => $this,
            ]);
        }
    }

    public function beforeSave($insert)
    {
        if($result = parent::beforeSave($insert)){
            $this->packValue();
        }

        return $result;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->unpackValue();
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->unpackValue();
    }

    protected function packValue()
    {
        $this->value = @serialize($this->value);
    }

    protected function unpackValue()
    {
        if(!is_null($this->value)){
            if(is_serialized( $original)){
                $this->value = @unserialize($this->value);
            }
        }
    }

}
