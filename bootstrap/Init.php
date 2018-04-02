<?php
namespace settings\bootstrap;

use yii\base\BootstrapInterface;
use yii\base\Application;

class Init implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () {
            $params = \Yii::$app->params;
            if (is_string($params) && is_file($configFilePath = \Yii::getAlias($params))) {
                $params = require($configFilePath);
            }
            \Yii::$container->set('settings\components\Params', $params);
            \Yii::$container->setSingleton('yii2Settings', 'settings\components\Params');
            \Yii::$app->params = \Yii::$container->get('yii2Settings');
        });
    }
}