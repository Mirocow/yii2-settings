<?php

namespace settings\components;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class Settings extends Component implements \ArrayAccess, \Iterator, \Countable
{
    public $dbEnabled = true;
    public $cache = 'cache';
    public $params = [];
    public $overwrite = true;
    public $cacheDuration = 60;

    /**
     * Init component
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->loadParams();
    }

    /**
     * Get params from DB
     * @return array
     */
    protected function getDbParams()
    {
        $params = [];

        if (!$this->dbEnabled) {
            return $params;
        }

        if($this->cache) {
            if ($this->cache->exists($this->getCacheKey())) {
                if (is_array($dbParams = $this->cache->get($this->getCacheKey()))) {
                    return $dbParams;
                }
            }
        }

        if(\Yii::$app->db->schema->getTableSchema(\settings\models\Settings::tableName())) {
            try {
                $query = $this->getQuery();
            } catch (Exception $e) {
                return $params;
            }

            $group_name = 'default';

            foreach ($query->each() as $k => $v) {
                if(!empty($v['group_name'])){
                    $group_name = $v['group_name'];
                }
                $params["{$group_name}.{$k}"] = $v['value'];
            }
        }

        if($this->cache) {
            $this->cache->set($this->getCacheKey(), $params, $this->cacheDuration);
        }

        return $params;
    }

    /**
     * Load and merge params
     * @throws InvalidConfigException
     */
    protected function loadParams()
    {
        $this->params = $this->overwrite ?
            $this->getDbParams() :
            ArrayHelper::merge($this->params, $this->getDbParams());

        ksort($this->params);
    }

    /**
     * Returns cache key
     * @return string
     */
    protected function getCacheKey()
    {
        return __CLASS__;
    }

    /**
     * @return Query
     */
    protected function getQuery()
    {
        return \settings\models\Settings::find()
            ->select(['key', 'value', 'group_name'])
            ->indexBy(function ($row) {
                return $row['key'];
            });
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        if (is_null($this->params)) {
            $this->loadParams();
        }
        return $this->getValue($offset);

    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        if (is_null($this->params)) {
            $this->loadParams();
        }
        return array_key_exists($offset, $this->params);
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($this->params)) {
            $this->loadParams();
        }
        $this->setValue($offset, $value);
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        if (is_null($this->params)) {
            $this->loadParams();
        }
        $this->removeValue($offset);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        if (is_null($this->params)) {
            $this->loadParams();
        }
        return current($this->params);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        if (is_null($this->params)) {
            $this->loadParams();
        }
        next($this->params);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return !is_null($this->key());
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        if (is_null($this->params)) {
            $this->loadParams();
        }
        return key($this->params);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        if (is_null($this->params)) {
            $this->loadParams();
        }
        reset($this->params);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        if (is_null($this->params)) {
            $this->loadParams();
        }
        return count($this->params);
    }

    /**
     * @return boolean
     */
    public function getDbEnabled()
    {
        return $this->dbEnabled;
    }

    /**
     * @param boolean $dbEnabled
     */
    public function setDbEnabled($dbEnabled)
    {
        $this->dbEnabled = $dbEnabled;
    }

    /**
     * @param $name
     * @param $value
     */
    private function setValue($name, $value)
    {
        ArrayHelper::setValue($this->params, $name, $value);
    }

    /**
     * @param $name
     * @return mixed
     */
    private function getValue($name)
    {
        return ArrayHelper::getValue($this->params, $name);
    }

    /**
     * @param $name
     * @return array
     */
    private function removeValue($name)
    {
        return ArrayHelper::removeValue($this->params, $name);
    }
}
