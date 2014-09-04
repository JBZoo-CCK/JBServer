<?php

defined('P_ROOT') or die('Restricted access');

/**
 * Class AppPHPModules
 */
class AppPHPModules
{
    /**
     * @var AppPHP
     */
    private $_phpHelper = null;

    /**
     *
     */
    function __construct()
    {
        $this->_phpHelper = new AppPHP();
    }

    /**
     * @param $moduleName
     * @return bool
     */
    public function checkModule($moduleName)
    {
        $moduleName = trim($moduleName);
        return extension_loaded($moduleName);
    }

    /**
     * @param $key
     * @return bool|null
     */
    public function getPHPParam($key)
    {
        return $this->_phpHelper->getParam($key);
    }
}