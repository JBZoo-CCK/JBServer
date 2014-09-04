<?php

defined('P_ROOT') or die('Restricted access');

/**
 * Class AppPHP
 */
class AppPHP
{
    /**
     * @param $key
     * @param string $type
     * @param string $default
     * @return array|bool|int|string
     */
    public function getParam($key, $type = 'string', $default = App::NONE)
    {
        $value = $this->_getIni($key);

        if ($value === false) {
            return $default;
        }

        if ($type == 'bool') {
            return $this->_getBoolean($value);

        } else if ($type == 'int') {
            return $this->_getInt($value);

        } else if ($type == 'array') {
            return $this->_getArray($value);

        } else if ($type == 'bytes') {
            return $this->_getBytes($value);

        } else if ($type == 'error') {
            return $this->_getError();

        } else if ($type == 'path') {
            return $this->_getPath($value);
        }

        $value = (string)$value;
        if (strlen($value) > 0) {
            return $value;
        }

        return App::NONE;
    }

    /**
     * @param $key
     * @return string
     */
    private function _getIni($key)
    {
        return @ini_get($key);
    }

    /**
     * @param $key
     * @return int|string
     */
    private function _getBytes($value)
    {
        if (empty($value)) {
            return 0;
        }

        $value = trim($value);

        preg_match('#([0-9]+)[\s]*([a-z]+)#i', $value, $matches);

        $last = '';
        if (isset($matches[2])) {
            $last = $matches[2];
        }

        if (isset($matches[1])) {
            $value = (int)$matches[1];
        }

        switch (strtolower($last)) {
            case 'g':
            case 'gb':
                $value *= 1024;
            case 'm':
            case 'mb':
                $value *= 1024;
            case 'k':
            case 'kb':
                $value *= 1024;
        }

        return App::formatFilesize((int)$value);
    }

    /**
     * @param $value
     * @return bool
     */
    private function _getBoolean($value)
    {
        switch (strtolower($value)) {
            case '1':
            case 'on':
            case 'yes':
            case 'true':
                return App::YES;
        }

        if ((bool)(int)$value) {
            return App::YES;
        }

        return App::NO;
    }

    /**
     * @param $value
     * @return int
     */
    private function _getInt($value)
    {
        $value = (int)$value;
        return number_format($value, 0, '.', ' ');
    }

    /**
     * Get PHP error types
     * @return  array
     */
    protected function _getErrorTypes()
    {
        $errType = array(
            E_ERROR             => 'Error',
            E_WARNING           => 'Warning',
            E_PARSE             => 'Parsing Error',
            E_NOTICE            => 'Notice',
            E_CORE_ERROR        => 'Core Error',
            E_CORE_WARNING      => 'Core Warning',
            E_COMPILE_ERROR     => 'Compile Error',
            E_COMPILE_WARNING   => 'Compile Warning',
            E_USER_ERROR        => 'User Error',
            E_USER_WARNING      => 'User Warning',
            E_USER_NOTICE       => 'User Notice',
            E_STRICT            => 'Runtime Notice',
            E_RECOVERABLE_ERROR => 'Catchable Fatal Error',
        );

        if (defined('E_DEPRECATED')) {
            $errType[E_DEPRECATED]      = 'Deprecated';
            $errType[E_USER_DEPRECATED] = 'User Deprecated';
        }

        $errType[E_ALL] = 'All errors';

        return $errType;
    }

    /**
     * @return string
     */
    private function _getError()
    {
        $level = (int)error_reporting();

        if ($level == -1) {
            return 'All errors (-1)';
        }

        if ($level == 0) {
            return App::NONE;
        }

        $allLevels = $this->_getErrorTypes();

        $result = array();
        foreach ($allLevels as $lvl => $lvlName) {
            if (($level & $lvl) == $lvl) {
                $result[] = $lvlName . ' (' . $lvl . ')';
            }
        }

        return implode('<br> ', $result);
    }

    /**
     * @param $value
     * @return int
     */
    private function _getPath($value)
    {


        $value = trim($value);
        if (!empty($value)) {
            return '<code>' . $value . '</code>';
        }

        return App::NONE;
    }

    /**
     * @param $value
     * @return array
     */
    private function _getArray($value, $separator = ',')
    {
        $value = strtolower($value);
        $list  = $value ? explode($separator, $value) : array();

        $result = array();
        foreach ($list as $func) {
            $result[] = trim($func);
        }

        sort($result);

        return $result;
    }

    /**
     * @return string
     */
    public function getDisableFunctions()
    {
        $funcs = getDisabledFunctions();

        return $this->phpLink($funcs);
    }

    /**
     * @return string
     */
    public function getDisabledClasses()
    {
        $classes = $this->getParam('disable_classes', 'array');

        return $this->phpLink($classes);
    }

    /**
     * @return string
     */
    public function checkCommandLine()
    {
        $cliFunctions = array('shell_exec', 'exec', 'system', 'popen', 'pcntl_exec');

        $result = false;
        foreach ($cliFunctions as $func) {
            if (checkFn($func)) {
                $result[] = $func;
            }
        }

        if (!empty($result)) {
            return App::YES . ' ' . $this->phpLink($result);
        }

        return App::NO;
    }

    /**
     * @param $values
     * @param string $sep
     * @return string
     */
    public function phpLink($values, $sep = ",\n ")
    {
        if (empty($values)) {
            return App::NONE;
        }

        if (!is_array($values)) {
            $values = array($values);
        }

        $result = array();
        foreach ($values as $value) {
            $result[] = '<a href="http://php.net/' . $value . '" target="_blank">' . $value . '</a>';
        }

        return implode($sep, $result);
    }

    /**
     * @return string
     */
    public function getOpenBasedir()
    {
        $paths = $this->getParam('open_basedir');

        if (empty($paths)) {
            return App::NONE;
        }

        $separator = ':';
        if (App::$isWin) {
            $separator = ';';
        }

        $paths = explode($separator, $paths);
        $paths = array_filter($paths);

        $result = array();
        foreach ($paths as $path) {
            $path = trim($path);
            if (!empty($path)) {
                $result[] = '<code>' . trim($path) . '</code>';
            }
        }

        return implode('<br>', $result);
    }

}

