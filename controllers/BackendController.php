<?php 

namespace settings\controllers;

use crud\controllers\CRUDController;
use settings\models\Settings;
use settings\models\SettingsSearch;

class BackendController extends CRUDController
{

    public function getModelClass()
    {
        return Settings::className();
    }

    public function getModelSearch()
    {
        return new SettingsSearch;
    }

    public function getPermissionPrefix()
    {
        return $this->module->patternPrefix;
    }

}
