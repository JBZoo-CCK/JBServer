<?php


/**
 * Translate texts
 * @param $langKey
 * @return mixed
 */
function _t($langKey)
{
    $langKey = trim(strtolower($langKey));

    if (isset($GLOBALS['_langs'][$langKey])) {
        return $GLOBALS['_langs'][$langKey];
    }

    return $langKey;
}

/**
 * @return array
 */
function getDisabledFunctions()
{
    static $result;

    if (!isset($result)) {
        $disabled = @ini_get('disable_functions');
        $disabled = strtolower(trim($disabled));
        $list     = $disabled ? explode(',', $disabled) : array();

        $result = array();
        foreach ($list as $func) {
            $result[] = trim($func);
        }

        $result = array_unique(array_filter($result));
        sort($result);
    }

    return $result;
}

/**
 * Check is functions exists
 * @param $fnList
 * @return bool
 */
function checkFn($fnList)
{
    $result = 1;

    if (is_array($fnList)) {

        foreach ($fnList as $fnName) {
            $result *= checkFn($fnName);
        }

    } else {
        $fnList    = strtolower(trim($fnList));
        $isExists  = function_exists($fnList);
        $isEnabled = in_array($fnList, getDisabledFunctions()) ? false : true;
        $result    = (int)$isEnabled && (int)$isExists;
    }

    return (bool)$result;
}

/**
 * @param null $mode
 * @return string
 */
function phpUname($mode = null)
{
    if (checkFn('php_uname')) {
        return @php_uname($mode);
    }

    if (strpos('n', $mode) !== false) {
        return $_SERVER['SERVER_NAME'];
    }

    if (strpos('s', $mode) !== false) {
        return PHP_OS;
    }

    return '-';
}
