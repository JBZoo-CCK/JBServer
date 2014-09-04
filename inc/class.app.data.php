<?php

defined('P_ROOT') or die('Restricted access');

class AppData
{
    /**
     * @var array
     */
    private $_data = array();

    /**
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->_data = (array)$data;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        }

        return $default;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->_data[$key] = $value;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->_data;
    }
}
