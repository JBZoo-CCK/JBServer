<?php

defined('P_ROOT') or die('Restricted access');

/**
 * Class AppBenchmark
 */
class AppBenchmark
{
    const TEST_COUNT = 1;
    const TEST_TABLE = 'jb_performance_test';

    /**
     * @var AppDb
     */
    protected $_db = null;

    /**
     * @var string
     */
    protected $_sessionGroup = 'benchmark';

    /**
     * @var string
     */
    protected $_testEmail = 'test@jbzoo.com';

    /**
     * Constructor
     * @param App $app
     */
    public function __construct()
    {
        $this->_db = AppDb::getInstance();
    }

    /**
     * Set env vars for testing
     */
    protected function _setEnvVars()
    {
        // set time limit
        @ini_set('max_execution_time', 60);
        if (checkFn('set_time_limit')) {
            @set_time_limit(1200);
        }

        // set memory limit
        @ini_set('memory_limit', '128M');

        // show errors
        @ini_set('error_reporting', -1);
        @ini_set('display_errors', 1);
        @ini_set('display_startup_errors', 1);
    }

    /**
     * Execute test by name
     * @param string $testName
     * @return array
     */
    public function execTest($testName)
    {
        $this->_setEnvVars();

        $actionName = '_test' . str_replace('_', '', $testName);

        if ($testName == 'cpu_complex') {
            $_SESSION[$this->_sessionGroup] = array();
        }

        if (method_exists($this, $actionName)) {

            //run tests
            $values = array();
            for ($j = 0; $j < self::TEST_COUNT; $j++) {

                $st     = microtime(true);
                $result = call_user_func(array($this, $actionName));
                $fin    = microtime(true);

                if (is_null($result)) {
                    $values[] = $fin - $st;
                } else {
                    $values[] = $result;
                }

                if (self::TEST_COUNT > 1) {
                    sleep(1); // without very hard test!
                }
            }

            $value = array_sum($values) / count($values);

            $this->_setSession($testName, $value);

            $this->_DbClose();

            // set output format
            return array(
                'value' => $this->toFormat($value, $testName),
                'alert' => $this->isAlert($value, $testName),
            );
        }

        return array();
    }

    /**
     * Open own DB conect
     * @return mixed
     */
    protected function _dbConnect()
    {
        if (!$this->_db->isConected()) {
            $this->_db->connect();
        }

        return $this->_db;
    }

    /**
     * Clear query to DB without
     * @param $query
     * @return mixed
     */
    protected function _DbQuery($query, $fetch = false, $oneRow = false)
    {
        if (!$this->_db->isConected()) {
            $this->_dbConnect();
        }

        return $this->_db->query($query, $fetch, $oneRow);
    }

    /**
     * Close own DB conect
     */
    protected function _DbClose()
    {
        if ($this->_db->isConected()) {
            $this->_db->close();
        }
    }

    /**
     * Create temporary table for tests
     */
    protected function _DbCreateTemp($isBx = false)
    {
        $this->_dbConnect();
        $this->_DbQuery('DROP TABLE IF EXISTS `' . self::TEST_TABLE . '`');
        if ($isBx) {
            $this->_DbQuery('CREATE TABLE `' . self::TEST_TABLE . '` (
                `ID` INT(18) NOT NULL AUTO_INCREMENT,
                `REFERENCE_ID` INT(18) NULL DEFAULT NULL,
                `NAME` VARCHAR(200) NULL DEFAULT NULL,
                PRIMARY KEY (`ID`),
                INDEX `IX_B_PERF_TEST_0` (`REFERENCE_ID`)
            ) COLLATE=\'utf8_general_ci\' ENGINE=MyISAM');
        } else {
            $this->_DbQuery('CREATE TABLE `' . self::TEST_TABLE . '`(i INT)  COLLATE=\'utf8_general_ci\' ENGINE=MyISAM');
        }
    }

    /**
     * Create temporary table for tests
     */
    protected function _DbRemoveTemp()
    {
        $this->_DbQuery('DROP TABLE IF EXISTS `' . self::TEST_TABLE . '`');
    }

    /**
     * CPU complex test
     */
    protected function _testCpuComplex()
    {
        $N1 = $N2 = $k = 0;

        $s1 = microtime(true);
        for ($i = 0; $i < 1000000; $i++) {
            // noop
        }
        $e1 = microtime(true);
        $N1 = $e1 - $s1;

        $s2 = microtime(true);
        for ($i = 0; $i < 1000000; $i++) {
            //This is one op
            $k++;
            $k--;
            $k++;
            $k--;
        }
        $e2 = microtime(true);
        $N2 = $e2 - $s2;

        if ($N2 > $N1) {
            return 1 / ($N2 - $N1);
        }

        return 0;
    }

    /**
     * CPU sin test
     */
    protected function _testCpuSin()
    {
        for ($i = 1; $i < 1000000; $i++) {
            $a = sin($i);
        }
    }

    /**
     * CPU sin test
     */
    protected function _testCpuConcatDot()
    {
        $a = $b = "";
        for ($i = 1; $i < 1000000; $i++) {
            $c = $a . $b;
        }
    }

    /**
     * CPU sin test
     */
    protected function _testCpuConcatQuotes()
    {
        $a = $b = "";
        for ($i = 1; $i < 1000000; $i++) {
            $c = "$a$b";
        }
    }

    /**
     * CPU sin test
     */
    protected function _testCpuConcatArray()
    {
        $a = $b = "";
        for ($i = 1; $i < 1000000; $i++) {
            implode("", array($a, $b));
        }
    }

    /**
     * MySQL connection test
     */
    protected function _testMysqlConnect()
    {
        $st = microtime(true);
        $this->_dbConnect();
        $fin = microtime(true);

        $this->_DbClose();

        return $fin - $st;
    }

    /**
     * MySQL sin test
     */
    protected function _testMysqlSin()
    {
        $this->_dbConnect();

        $st = microtime(true);
        $this->_DbQuery('SELECT BENCHMARK(1000000, (select sin(100)))');
        $fin = microtime(true);

        $this->_DbClose();

        return $fin - $st;
    }

    /**
     * Mysql Insert test
     */
    protected function _testMysqlInsert()
    {
        // prepare
        $this->_DbCreateTemp();

        $st = microtime(true);
        for ($i = 0; $i < 10000; $i++) {
            $this->_DbQuery('INSERT INTO `' . self::TEST_TABLE . '` values (' . $i . ')');
        };
        $fin = microtime(true);

        // drop & close
        $this->_DbRemoveTemp();

        return $fin - $st;
    }

    /**
     * Mysql Insert test
     */
    protected function _testMysqlSelect()
    {
        // prepare
        $this->_DbCreateTemp();

        // add entries
        for ($i = 0; $i < 10000; $i++) {
            $this->_DbQuery('INSERT INTO `' . self::TEST_TABLE . '` VALUES (' . $i . ')');
        };

        $st     = microtime(true);
        $result = $this->_DbQuery('SELECT * FROM `' . self::TEST_TABLE . '` WHERE i > 0');
        while ($row = mysqli_fetch_assoc($result)) ;
        $fin = microtime(true);

        // drop & close
        $this->_DbRemoveTemp();

        return $fin - $st;
    }

    /**
     * Mysql Insert test
     */
    protected function _testMysqlSelectAdvance()
    {
        // prepare
        $this->_DbCreateTemp(true);

        $strSql = "INSERT INTO `" . self::TEST_TABLE . "` (REFERENCE_ID, NAME) values (#i#-1, '" . str_repeat("x", 200) . "')";
        for ($i = 0; $i < 100; $i++) {
            $this->_DbQuery(str_replace("#i#", $i, $strSql));
        }

        $strSql = 'SELECT * FROM `' . self::TEST_TABLE . '` WHERE ID = #i#';

        for ($j = 0; $j < 4; $j++) {
            $N1 = $N2 = 0;

            $s1 = microtime(true);
            for ($i = 0; $i < 100; $i++) {
                $sql = str_replace("#i#", $i, $strSql);
            }
            $e1 = microtime(true);
            $N1 = $e1 - $s1;

            $s2 = microtime();
            for ($i = 0; $i < 100; $i++) {
                mysqli_fetch_assoc($this->_DbQuery(str_replace("#i#", $i, $strSql)));
            }
            $e2 = microtime();
            $N2 = $e2 - $s2;

            if ($N2 > $N1) {
                $res[] = 100 / ($N2 - $N1);
            }
        }

        $this->_DbRemoveTemp();

        if (count($res)) {
            return array_sum($res) / doubleval(count($res));
        } else {
            return 0;
        }
    }

    /**
     * Mysql Insert test
     */
    protected function _testMysqlReplaceAdvance()
    {
        // prepare
        $this->_DbCreateTemp(true);

        $strSql = "INSERT INTO `" . self::TEST_TABLE . "` (REFERENCE_ID, NAME) values (#i#-1, '" . str_repeat("x", 200) . "')";
        for ($i = 0; $i < 100; $i++) {
            $this->_DbQuery(str_replace("#i#", $i, $strSql));
        }

        $strSql = "UPDATE `" . self::TEST_TABLE . "` SET REFERENCE_ID = ID+1, NAME = '" . str_repeat("y", 200) . "' WHERE ID = #i#";

        for ($j = 0; $j < 4; $j++) {
            $N1 = $N2 = 0;

            $s1 = microtime(true);
            for ($i = 0; $i < 100; $i++) {
                $sql = str_replace("#i#", $i, $strSql);
            }
            $e1 = microtime(true);
            $N1 = $e1 - $s1;

            $s2 = microtime();
            for ($i = 0; $i < 100; $i++) {
                $this->_DbQuery(str_replace("#i#", $i, $strSql));
            }
            $e2 = microtime();
            $N2 = $e2 - $s2;

            if ($N2 > $N1) {
                $res[] = 100 / ($N2 - $N1);
            }
        }

        $this->_DbRemoveTemp();

        if (count($res)) {
            return array_sum($res) / doubleval(count($res));
        } else {
            return 0;
        }
    }

    /**
     * @return float
     */
    protected function _testMysqlInsertAdvance()
    {
        // prepare
        $this->_DbCreateTemp(true);

        $strSql = "INSERT INTO `" . self::TEST_TABLE . "` (REFERENCE_ID, NAME) values (#i#-1, '" . str_repeat("x", 200) . "')";

        for ($j = 0; $j < 4; $j++) {
            $N1 = $N2 = 0;

            $s1 = microtime(true);
            for ($i = 0; $i < 100; $i++) {
                $sql = str_replace("#i#", $i, $strSql);
            }
            $e1 = microtime(true);
            $N1 = $e1 - $s1;

            $s2 = microtime();
            for ($i = 0; $i < 100; $i++) {
                $this->_DbQuery(str_replace("#i#", $i, $strSql));
            }
            $e2 = microtime();
            $N2 = $e2 - $s2;

            if ($N2 > $N1) {
                $res[] = 100 / ($N2 - $N1);
            }
        }

        $this->_DbRemoveTemp();

        if (count($res)) {
            return array_sum($res) / doubleval(count($res));
        } else {
            return 0;
        }
    }

    /**
     * FileSystem complex test
     */
    protected function _testFsSimple()
    {
        $fileName = App::cleanPath(P_ROOT . "/tmp/JBServerChecker_test_#i#.php");

        $N1 = $N2 = 0;

        $s1 = microtime(true);
        for ($i = 0; $i < 100; $i++) {
            // noop
        }
        $e1 = microtime(true);
        $N1 = $e1 - $s1;

        $s2 = microtime(true);
        for ($i = 0; $i < 100; $i++) {
            $fn = str_replace("#i#", $i, $fileName);
            $fh = fopen($fn, "wb");
            fclose($fh);
            unlink($fn);
        }
        $e2 = microtime(true);
        $N2 = $e2 - $s2;

        if ($N2 > $N1) {
            return 100 / ($N2 - $N1);
        }

        return 0;
    }

    /**
     * FileSystem write by one byte
     */
    protected function _testFsWrite()
    {
        $fileName = App::cleanPath(P_ROOT . "/tmp/JBServerChecker_test_write");

        if (!$handle = fopen($fileName, 'wb')) {
            die ('Can not open file for writing ' . $fileName);
        }

        $st = microtime(true);
        for ($i = 0; $i < 1000000; $i++) {
            fwrite($handle, '1');
        }
        $fin = microtime(true);

        fclose($handle);
        unlink($fileName);

        return $fin - $st;
    }

    /**
     * FileSystem read by one byte
     */
    protected function _testFsRead()
    {
        $fileName = App::cleanPath(P_ROOT . "/tmp/JBServerChecker_test_read");

        $handle = fopen($fileName, 'wb');
        for ($i = 0; $i < 1000000; $i++) {
            fwrite($handle, '1');
        }
        fclose($handle);

        $handle = fopen($fileName, 'r');

        $st = microtime(true);
        while (!feof($handle)) {
            fread($handle, 1);
        }
        $fin = microtime(true);

        fclose($handle);
        unlink($fileName);

        return $fin - $st;
    }

    /**
     * FileSystem complex test
     */
    protected function _testFsComplex()
    {
        $fileName = App::cleanPath(P_ROOT . "/tmp/JBServerChecker_test_#i#.php");

        $content =
            "<?php \$s='" . str_repeat("x", 1024) . "';?> \n" .
            "<?php /*" . str_repeat("y", 1024) . "*/?> \n" .
            "<?php \$r='" . str_repeat("z", 1024) . "';?>";

        $N1 = $N2 = 0;

        $s1 = microtime(true);
        for ($i = 0; $i < 100; $i++) {
            // noop
        }
        $e1 = microtime(true);
        $N1 = $e1 - $s1;

        $s2 = microtime(true);
        for ($i = 0; $i < 100; $i++) {
            $fn = str_replace("#i#", $i, $fileName);
            $fh = fopen($fn, "wb");
            fwrite($fh, $content);
            fclose($fh);
            include $fn;
            unlink($fn);
        }
        $e2 = microtime(true);
        $N2 = $e2 - $s2;

        if ($N2 > $N1) {
            return 100 / ($N2 - $N1);
        }

        return 0;
    }

    /**
     * Send email via mail()
     */
    protected function _testMailPhp()
    {
        mail($this->_testEmail, "JBServerChecker email test", "This is test message. Delete it.");
    }

    /**
     * Get session start time
     */
    protected function _testSessionInit()
    {
        $testUrl = App::getRootUrl(true) . '/?' . http_build_query(array(
                'task'    => 'check-session',
                'nocache' => mt_rand(),
            ));

        $values = array();
        for ($j = 0; $j < 10; $j++) {
            $values[] = (float)file_get_contents($testUrl);
        }

        return array_sum($values) / count($values);
    }

    /**
     * Engine start test
     */
    protected function _testEngineInit()
    {
        static $result;

        if (isset($_SERVER['REQUEST_TIME_FLOAT']) && !isset($result)) {
            $result = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
        }

        return $result;
    }

    /**
     * Calc total score
     */
    protected function _testTotalScore()
    {
        return $this->_getTotalRate();
    }

    /**
     * Calc cpu score
     */
    protected function _testTotalCPU()
    {
        return $this->_getTotalRate('cpu');
    }

    /**
     * Calc mysql score
     */
    protected function _testTotalMySQL()
    {
        if ($this->_db->checkLib()) {
            return $this->_getTotalRate('mysql');
        }

        return 0;
    }

    /**
     * Calc FS score
     */
    protected function _testTotalFS()
    {
        return $this->_getTotalRate('fs');
    }

    /**
     * Calc mysql score
     */
    protected function _testTotalMail()
    {
        return $this->_getTotalRate('mail');
    }

    /**
     * Get OS type
     */
    protected function _testVersionOS()
    {
        return PHP_OS;
    }

    /**
     * Get PHP version
     */
    protected function _testVersionPHP()
    {
        return phpversion();
    }

    /**
     * Calc total score
     */
    protected function _getTotalRate($group = null)
    {
        $values = $this->_getSession()->toArray();

        $result = array();

        $stdValues = $this->getStdValues();
        foreach ($values as $testName => $value) {

            $std = $stdValues[$testName];
            list($testGroup) = explode('_', $testName);

            if (!in_array($testGroup, array('cpu', 'mysql', 'fs', 'mail'))) {
                continue;
            }

            if (($group && $group != $testGroup)) {
                continue;
            }

            $rel = $value / $std['std'];

            if ($std['type'] == 'less' && $value > $std['std']) {
                $result[$testName] = -(100 - ((1 / $rel) * 100));

            } else if ($std['type'] == 'more' && $value < $std['std']) {
                $result[$testName] = -(100 - ($rel * 100));

            } else if ($std['type'] == 'more') {
                $result[$testName] = $rel * 100;

            } else if ($std['type'] == 'less') {
                $result[$testName] = (1 - $rel) * 100;

            } else {
                $result[$testName] = $rel * 100;
            }
        }

        $totalRes = (array_sum($result) / count($result));
        return $totalRes;
    }

    /**
     * Get fail test count
     */
    protected function _testTotalFail()
    {
        $values = $this->_getSession()->toArray();
        $result = 0;

        $stdValues = $this->getStdValues();

        foreach ($values as $testName => $value) {

            $std = $stdValues[$testName];
            if ($std['type'] == 'less' && $value > $std['std']) {
                $result++;
            } else if ($std['type'] == 'more' && $value < $std['std']) {
                $result++;
            }
        }

        $result--;
        return ($result <= 0) ? 0 : $result;
    }

    /**
     * @return
     */
    protected function _getSession()
    {
        $session = array();
        if (isset($_SESSION[$this->_sessionGroup])) {
            $session = $_SESSION[$this->_sessionGroup];
        }

        return $this->_createData($session);
    }

    /**
     * @return
     */
    protected function _setSession($key, $value)
    {
        if (!isset($_SESSION[$this->_sessionGroup])) {
            $_SESSION[$this->_sessionGroup] = array();
        }

        $_SESSION[$this->_sessionGroup][$key] = $value;
    }

    /**
     * @param $data
     * @return AppData
     */
    protected function _createData($data)
    {
        return new AppData($data);
    }

    /**
     * @return array
     */
    public function getTestData()
    {
        static $result;

        if (!isset($result)) {

            $values = $this->_getSession();

            $result = array(
                'cpu'    => array(
                    array(
                        'key'      => 'cpu_complex',
                        'type'     => 'more',
                        'value'    => $values->get('cpu_complex', '-'),
                        'standart' => 9.0,
                        'postfix'  => 'mil_in_sec'
                    ),
                    array(
                        'key'      => 'cpu_sin',
                        'type'     => 'less',
                        'value'    => $values->get('cpu_sin', '-'),
                        'standart' => 0.300,
                        'postfix'  => 'in_sec'
                    ),
                    array(
                        'key'      => 'cpu_concat_dot',
                        'type'     => 'less',
                        'value'    => $values->get('cpu_concat_dot', '-'),
                        'standart' => 0.200,
                        'postfix'  => 'in_sec'
                    ),
                    array(
                        'key'      => 'cpu_concat_quotes',
                        'type'     => 'less',
                        'value'    => $values->get('cpu_concat_quotes', '-'),
                        'standart' => 0.250,
                        'postfix'  => 'in_sec'
                    ),
                    array(
                        'key'      => 'cpu_concat_array',
                        'type'     => 'less',
                        'value'    => $values->get('cpu_concat_array', '-'),
                        'standart' => 0.600,
                        'postfix'  => 'in_sec'
                    ),
                ),
                'mysql'  => array(
                    array(
                        'key'      => 'mysql_connect',
                        'type'     => 'less',
                        'value'    => $values->get('mysql_connect', '-'),
                        'standart' => 0.005,
                        'postfix'  => 'in_sec'
                    ),
                    array(
                        'key'      => 'mysql_sin',
                        'type'     => 'less',
                        'value'    => $values->get('mysql_sin', '-'),
                        'standart' => 0.100,
                        'postfix'  => 'in_sec'
                    ),
                    array(
                        'key'      => 'mysql_insert',
                        'type'     => 'less',
                        'value'    => $values->get('mysql_insert', '-'),
                        'standart' => 3.000,
                        'postfix'  => 'in_sec'
                    ),
                    array(
                        'key'      => 'mysql_select',
                        'type'     => 'less',
                        'value'    => $values->get('mysql_select', '-'),
                        'standart' => 0.030,
                        'postfix'  => 'in_sec'
                    ),
                    array(
                        'key'      => 'mysql_select_advance',
                        'type'     => 'more',
                        'value'    => $values->get('mysql_select_advance', '-'),
                        'standart' => 7800,
                        'postfix'  => ''
                    ),
                    array(
                        'key'      => 'mysql_insert_advance',
                        'type'     => 'more',
                        'value'    => $values->get('mysql_insert_advance', '-'),
                        'standart' => 5600,
                        'postfix'  => ''
                    ),
                    array(
                        'key'      => 'mysql_replace_advance',
                        'type'     => 'more',
                        'value'    => $values->get('mysql_replace_advance', '-'),
                        'standart' => 5800,
                        'postfix'  => ''
                    ),
                ),
                'fs'     => array(
                    array(
                        'key'      => 'fs_simple',
                        'type'     => 'more',
                        'value'    => $values->get('fs_simple', '-'),
                        'standart' => 20000,
                        'postfix'  => ''
                    ),
                    array(
                        'key'      => 'fs_complex',
                        'type'     => 'more',
                        'value'    => $values->get('fs_complex', '-'),
                        'standart' => 8000,
                        'postfix'  => ''
                    ),
                    array(
                        'key'      => 'fs_write',
                        'type'     => 'less',
                        'value'    => $values->get('fs_write', '-'),
                        'standart' => 3.500,
                        'postfix'  => 'in_sec'
                    ),
                    array(
                        'key'      => 'fs_read',
                        'type'     => 'less',
                        'value'    => $values->get('fs_read', '-'),
                        'standart' => 0.350,
                        'postfix'  => 'in_sec'
                    ),
                ),
                'others' => array(
                    array(
                        'key'      => 'mail_php',
                        'type'     => 'less',
                        'value'    => $values->get('mail_php', '-'),
                        'standart' => 0.100,
                        'postfix'  => 'in_sec'
                    ),
                    array(
                        'key'      => 'session_init',
                        'type'     => 'less',
                        'value'    => $values->get('session_init', '-'),
                        'standart' => 0.005,
                        'postfix'  => 'in_sec'
                    ),
                ),
                'result' => array(
                    array(
                        'key'      => 'total_cpu',
                        'type'     => 'more',
                        'value'    => $values->get('total_cpu', '-'),
                        'standart' => 0,
                        'postfix'  => ''
                    ),
                    array(
                        'key'      => 'total_mysql',
                        'type'     => 'more',
                        'value'    => $values->get('total_mysql', '-'),
                        'standart' => 0,
                        'postfix'  => ''
                    ),
                    array(
                        'key'      => 'total_mail',
                        'type'     => 'more',
                        'value'    => $values->get('total_mail', '-'),
                        'standart' => 0,
                        'postfix'  => ''
                    ),
                    array(
                        'key'      => 'total_fs',
                        'type'     => 'more',
                        'value'    => $values->get('total_fs', '-'),
                        'standart' => 0,
                        'postfix'  => ''
                    ),
                    array(
                        'key'      => 'total_score',
                        'type'     => 'more',
                        'value'    => $values->get('total_score', '-'),
                        'standart' => 0,
                        'postfix'  => ''
                    ),
                    array(
                        'key'      => 'total_fail',
                        'type'     => 'less',
                        'value'    => $values->get('total_fail', '-'),
                        'standart' => 0,
                        'postfix'  => ''
                    ),
                ),
            );

            if (!$this->_db->checkLib()) {
                unset($result['mysql']);
                unset($result['result']['1']);
            }
        }

        return $result;
    }

    /**
     * Value to human readble format
     * @param $value
     * @param $key
     * @return string
     */
    public function toFormat($value, $key)
    {
        if ($value == '-') {
            return $value;

        } else if ($key == 'total_fail') {
            return (int)$value;

        } else if ($key == 'system_loadavg') {
            return number_format($value, 2, '.', ' ');

        } else if (strpos($key, 'version') === 0) {
            return $value;

        } else if (strpos($key, 'total') === 0) {
            return number_format($value, 0, '.', ' ');

        } else if (in_array($key, array('memory_peak', 'realpath_remaining', 'realpath_used'))) {
            return App::formatFilesize($value);

        } else if ($value > 100) {
            return number_format($value, 0, '.', ' ');

        } else if ($value > 50) {
            return number_format($value, 1, '.', ' ');

        } else if ($value > 1) {
            return number_format($value, 2, '.', ' ');

        } else if ($value > 0.01) {
            return number_format($value, 3, '.', ' ');

        } else {
            return number_format($value, 4, '.', ' ');
        }
    }

    /**
     * Get standart values
     */
    public function getStdValues()
    {
        $testGroups = $this->getTestData();
        $result     = array();

        foreach ($testGroups as $tests) {
            foreach ($tests as $test) {
                $result[$test['key']] = array(
                    'std'  => $test['standart'],
                    'type' => $test['type'],
                );
            }

        }

        return $result;
    }

    /**
     * Check, is current value in test is warning
     * @param $value
     * @param $testName
     * @return bool
     */
    public function isAlert($value, $testName)
    {
        $stdValues = $this->getStdValues();
        $std       = $stdValues[$testName]['std'];

        $isAlert = false;
        if ($stdValues[$testName]['type'] == 'none') {
            $isAlert = -1;
        }

        if ($stdValues[$testName]['type'] == 'less' && $value > $std) {
            $isAlert = true;
        }

        if ($stdValues[$testName]['type'] == 'more' && $value < $std) {
            $isAlert = true;
        }

        return $isAlert;
    }

}
