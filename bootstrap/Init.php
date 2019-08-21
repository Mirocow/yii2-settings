<?php
namespace mirocow\settings\bootstrap;

use yii\base\BootstrapInterface;
use yii\base\Application;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\caching\Cache;

class Init implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () {
            if(!is_object(\Yii::$app->params)) {
                $className = \settings\components\Settings::class;

                $cache = \Yii::$app->cache;

                if (!$cache) {
                    if(\Yii::$app->has('cache')) {
                        $cache = Instance::ensure('cache', Cache::className());
                    }
                }

                $params = [
                    'params' => \Yii::$app->params,
                    'cache'  => $cache,
                ];

                if (isset(\Yii::$app->components[ 'settings' ])) {
                    $params = ArrayHelper::merge($params, \Yii::$app->components[ 'settings' ]);
                }

                if (isset(\Yii::$app->components[ 'settings' ][ 'class' ])) {
                    $className = \Yii::$app->components[ 'settings' ][ 'class' ];
                    unset($params[ 'class' ]);
                }

                \Yii::$container->set($className, $params);
                \Yii::$container->setSingleton('yii2Settings', $className);
                \Yii::$app->params = ArrayHelper::merge(\Yii::$app->params, \Yii::$container->get('yii2Settings'));
            }
        });
    }
}