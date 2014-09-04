<?php

defined('P_ROOT') or die('Restricted access');

/**
 * Class AppBenchmark
 */
class AppDb
{

    /**
     * @var mysqli
     */
    private $_dbLink = null;

    /**
     * Proteced contructor
     */
    private function __construct()
    {

    }

    /**
     * @return AppDb
     */
    public static function getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        if ($this->checkLib()) {

            $this->connect();

            if ($this->isConected()) {
                return mysqli_get_server_info($this->_dbLink);
            }
        }

        return '-';
    }

    /**
     * @return bool
     */
    public function checkLib()
    {
        return extension_loaded('mysqli');
    }

    /**
     * @return bool
     */
    public function isConected()
    {
        return !empty($this->_dbLink);
    }

    /**
     * Open own DB conect
     * @return mysqli
     */
    public function connect()
    {
        if (!$this->checkLib()) {
            return null;
        }

        if (is_null($this->_dbLink)) {
            $this->_dbLink = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        }

        return $this->_dbLink;
    }

    /**
     * Clear query to DB
     * @param $query
     * @param bool $fetch
     * @param bool $oneRow
     * @return array|bool|mysqli_result|null
     */
    public function query($query, $fetch = true, $oneRow = true)
    {
        if (!$this->checkLib()) {
            return null;
        }

        if (is_null($this->_dbLink)) {
            $this->connect();
        }

        if ($this->_dbLink === false) {
            return null;
        }

        $dbRes  = mysqli_query($this->_dbLink, $query);
        $result = $dbRes;

        if ($fetch) {
            if ($oneRow) {
                $result = mysqli_fetch_assoc($dbRes);
            } else {
                $result = array();
                while ($row = mysqli_fetch_assoc($dbRes)) {
                    $result[] = $row;
                }
            }
        }

        return $result;
    }

    /**
     * Close mysql conect
     * @return bool
     */
    public function close()
    {
        if (!$this->checkLib()) {
            return null;
        }

        if ($this->_dbLink === false) {
            return null;
        }

        if (!is_null($this->_dbLink)) {
            mysqli_close($this->_dbLink);
            $this->_dbLink = null;
        }
    }
}
