<?php

defined('P_ROOT') or die('Restricted access');

/**
 * Class AppOverview
 */
class AppOverview
{

    /**
     * @return string
     */
    public function getOS()
    {
        return PHP_OS;
    }

    /**
     * @return string
     */
    public function getPHPVersion()
    {
        return phpversion();
    }

    /**
     * @return string
     */
    public function getApacheVersion()
    {
        if (checkFn('apache_get_version')) {
            return apache_get_version();
        }

        return '-';
    }

    /**
     * @return string
     */
    public function getMySQLVersion()
    {
        $db = AppDb::getInstance();
        return $db->getVersion();
    }

    /**
     * @return string
     */
    public function getZendEngineVersion()
    {
        if (checkFn('zend_version')) {
            return zend_version();
        }
        return '-';
    }

    /**
     * @return array
     */
    public function getLoadAvg()
    {
        if (checkFn('sys_getloadavg')) {

            $la = sys_getloadavg();

            $result = array();
            foreach ($la as $key => $laValue) {

                if ($laValue >= 10) {
                    $result[$key] = array('state' => 'danger');
                } else if ($laValue >= 5) {
                    $result[$key] = array('state' => 'warning');
                } else {
                    $result[$key] = array('state' => 'success');
                }

                $result[$key]['value'] = $laValue;
            }

            return $result;

        }

        return array();
    }

    /**
     * @return string
     */
    public function getServerUptime()
    {
        $cmdLine = new AppCommandline();
        $data    = $cmdLine->catFile('/proc/uptime');

        $uptime  = $idle = 0;
        $percent = null;
        if ($data) {
            list($uptime, $idle) = explode(' ', $data);

            $uptime  = (int)$uptime;
            $idle    = (int)$idle / $this->getSystemCores();
            $percent = '(' . round(($idle / $uptime) * 100, 2) . '%)';

        }

        return array(
            'uptime'  => $uptime,
            'idle'    => $idle,
            'percent' => $percent,
        );
    }

    /**
     * @return string
     */
    public function getMySQLUptime()
    {
        $db     = AppDb::getInstance();
        $result = $db->query('SHOW GLOBAL STATUS LIKE "%Uptime%"');

        return (int)$result['Value'];
    }

    /**
     * @return bool|string
     */
    public function getMysqlRestartDate()
    {
        $uptime = $this->getMySQLUptime();
        if ($uptime) {
            $time = time() - $uptime;
            return date(DATE_RFC822, $time);
        }

        return '-';
    }

    /**
     * @return bool|string
     */
    public function getServerRestartDate()
    {
        $uptimeData = $this->getServerUptime();
        if ($uptimeData['uptime'] > 0) {
            $time = time() - $uptimeData['uptime'];
            return date(DATE_RFC822, $time);
        }

        return '-';
    }

    /**
     * @return int
     */
    public function getSystemCores()
    {
        $default = 1;

        $cmdLine = new AppCommandline();

        $os = strtolower(trim($cmdLine->exec('uname')));

        if ($os == 'linux') {
            $cmd = "cat /proc/cpuinfo | grep processor | wc -l";
        } else if ($os == 'freebsd') {
            $cmd = "sysctl -a | grep 'hw.ncpu' | cut -d ':' -f2";
        } else {
            $cmd = false;
        }

        if (!empty($cmd)) {
            $cpuCoreNo = intval(trim($cmdLine->exec($cmd)));
            return $cpuCoreNo;
        }

        return $default;
    }

    /**
     * @param $data
     * @return string
     */
    public function secToHuman($data)
    {
        if ($data <= 0) {
            return '-';
        }

        $result = array(
            '<span class="label label-primary">' . floor($data / 60 / 60 / 24) . ' days</span>',
            $data / 60 / 60 % 24 . ' hours',
            $data / 60 % 60 . ' minutes',
            $data % 60 . ' seconds'
        );

        return implode(' ', $result);
    }

    /**
     * @return string
     */
    public function getFreeDiskSpace()
    {
        $path = P_ROOT;
        if (isset($_SERVER["DOCUMENT_ROOT"]) && !empty($_SERVER["DOCUMENT_ROOT"])) {
            $path = $_SERVER["DOCUMENT_ROOT"];
        }

        $free = (float)disk_free_space($path);

        return App::formatFilesize($free);
    }

    /**
     *
     */
    public function getMemoryData()
    {
        $cmdLine = new AppCommandline();

        $availMemory = $totalMemory = '-';

        if (!App::$isWin) {
            $consoleInfo = $cmdLine->exec("free -m");
            if ($consoleInfo) {
                $serverReply = explode("\n", str_replace("\r", "", $consoleInfo));

                $consoleInfo = array_slice($serverReply, 1, 1);
                $consoleInfo = preg_split("#\s+#", $consoleInfo[0]);

                $totalMemory = ($consoleInfo[1]) ? $consoleInfo[1] . ' MB' : '-';
                $availMemory = ($consoleInfo[3]) ? $consoleInfo[3] . ' MB' : '-';
            }

        }

        return array('total' => $totalMemory, 'avail' => $availMemory);
    }

}
