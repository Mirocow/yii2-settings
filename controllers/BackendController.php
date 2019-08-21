<?php 

namespace mirocow\settings\controllers;

use crud\controllers\CRUDController;

class BackendController extends CRUDController
{

    public function getModelClass()
    {
        return $this->module->model;
    }

    public function getModelSearch()
    {
        return new $this->module->modelSearch;
    }

    public function getPermissionPrefix()
    {
        return $this->module->patternPrefix;
    }

}
