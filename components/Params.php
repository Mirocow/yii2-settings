<?php

namespace settings\components;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\caching\DbDependency;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

class Params extends Component implements \ArrayAccess, \Iterator, \Countable
{
    protected $_dbEnabled = true;
    protected $_cache = 'cache';
    protected $_params = null;
    protected $_overwrite = true;
    protected $_filePath = '@app/config/params.php';

    /**
     * Init component
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->_cache = Instance::ensure($this->_cache, Cache::className());
    }

    /**
     * Get params from DB
     * @return array
     */
    protected function getDbParams()
    {
        $params = [];

        if (!$this->_dbEnabled) {
            return $params;
        }

        if ($this->getCache()->exists($this->getCacheKey())) {
            if (is_array($dbParams = $this->getCache()->get($this->getCacheKey()))) {
                return $dbParams;
            }
        }

        $query = $this->getQuery();

        foreach ($query->each() as $k => $v) {
            $params[$k] = $v['value'];
        }
        $this->getCache()->set($this->getCacheKey(), $params, $this->getCacheDuration(), $this->getDbDependency());
        return $params;
    }

    /**
     * Load and merge params
     * @throws InvalidConfigException
     */
    protected function loadParams()
    {
        $this->_params = $this->getOverwrite() ?
            ArrayHelper::merge($this->getFileParams(), $this->getDbParams()) :
            ArrayHelper::merge($this->getDbParams(), $this->getFileParams());

        ksort($this->_params);
    }

    /**
     * Load params from php file
     * @return array
     * @throws InvalidConfigException
     */
    public function getFileParams()
    {
        if (is_null($this->getFilePath())) {
            return [];
        }

        $fileParams = [];
        $filePaths = $this->getFilePath();
        if (!is_array($filePaths)) {
            $filePaths = [$filePaths];
        }

        foreach ($filePaths as $filePath) {
            $file = \Yii::getAlias($filePath);
            if (!is_file($file)) {
                throw new InvalidConfigException("Params file {$file} not found");
            }
            $fileParams = ArrayHelper::merge($fileParams, require($file));
        }

        return $fileParams;
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
        return Settings::find()
            ->select(['name', 'value'])
            ->indexBy(function ($row) {
                return $row['name'];
            });
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        if ($this->offsetExists($offset)) {
            return $this->_params[$offset];
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        return array_key_exists($offset, $this->_params);
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        $this->_params[$offset] = $value;
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        unset($this->_params[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        return current($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        next($this->_params);
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
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        return key($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        reset($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        return count($this->_params);
    }

    /**
     * @return string|array
     */
    public function getFilePath()
    {
        return $this->_filePath;
    }

    /**
     * @param string|attay $filePath
     */
    public function setFilePath($filePath)
    {
        $this->_filePath = $filePath;
    }

    /**
     * Is DB parameter override
     *
     * @return boolean
     */
    public function getOverwrite()
    {
        return $this->_overwrite;
    }

    /**
     * @param boolean $overwrite
     */
    public function setOverwrite($overwrite)
    {
        $this->_overwrite = $overwrite;
    }

    /**
     * @return string|Cache
     */
    public function getCache()
    {
        return $this->_cache;
    }

    /**
     * @param string|Cache $cache
     */
    public function setCache($cache)
    {
        $this->_cache = $cache;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->_tableName = $tableName;
    }

    /**
     * @return boolean
     */
    public function getDbEnabled()
    {
        return $this->_dbEnabled;
    }

    /**
     * @param boolean $dbEnabled
     */
    public function setDbEnabled($dbEnabled)
    {
        $this->_dbEnabled = $dbEnabled;
    }
}