<?php 

namespace mirocow\settings;

use mirocow\settings\models\Settings;
use mirocow\settings\models\SettingsSearch;
use Yii;

class Module extends \yii\base\Module
{

    public $patternPrefix = 'settings';
    public $backendMode = FALSE;
    public $model = Settings::class;
    public $modelSearch = SettingsSearch::class;

    public function init()
    {
        parent::init();

        if(($app = Yii::$app) instanceof \yii\web\Application AND $this->backendMode){
            $app->getUrlManager()->addRules([
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->patternPrefix, 'route' => $this->id . '/backend/index', ],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->patternPrefix . '/create', 'route' => $this->id . '/backend/create', ],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->patternPrefix . '/<id>', 'route' => $this->id . '/backend/view', ],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->patternPrefix . '/update/<id>', 'route' => $this->id . '/backend/update', ],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->patternPrefix . '/delete/<id>', 'route' => $this->id . '/backend/delete', ],
            ], FALSE);
        }

    }

}
