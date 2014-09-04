<?php

defined('P_ROOT') or die('Restricted access');

class App
{

    const YES  = '<span class="label label-success">yes</span>';
    const NO   = '<span class="label label-primary">no</span>';
    const NONE = '<span class="label label-default">none</span>';

    static public $isWin = null;

    /**
     * Constructor
     */
    protected function __construct()
    {
        $task = $this->getTask();
        if (!session_id() && $task != 'check-session') {
            session_start();
        }

        self::$isWin = substr(strtolower(PHP_OS), 0, 3) == "win";
    }

    /**
     * @return App
     */
    public static function getInstance()
    {
        static $app;
        if (!isset($app)) {
            $app = new self();
        }
        return $app;
    }

    /**
     * @return string
     */
    public function getTask()
    {
        $task = isset($_REQUEST['task']) ? $_REQUEST['task'] : 'index';
        $task = trim($task);
        $task = strtolower($task);

        return $task;
    }

    /**
     * Show home page
     */
    public function pageIndex()
    {
        return self::renderTmpl('index');
    }

    /**
     * @return string
     */
    public function execTest()
    {
        $testName = isset($_REQUEST['testname']) ? $_REQUEST['testname'] : '';

        ob_start();
        $benchHelper = new AppBenchmark();
        $result      = $benchHelper->execTest($testName);
        ob_end_clean();

        return json_encode($result);
    }

    /**
     *
     */
    public function assets()
    {
        $file = isset($_REQUEST['file']) ? $_REQUEST['file'] : '';
    }

    /**
     * @param $path
     * @param string $ds
     * @return mixed|string
     */
    static public function cleanPath($path, $ds = DS)
    {
        $path = trim($path);
        $path = rtrim($path, "\\/");

        if (!empty($path)) {
            $path = preg_replace('#[/\\\\]+#', $ds, $path);
        }

        return $path;
    }

    /**
     * @param $viewName
     * @param array $params
     * @return null|string
     */
    public static function renderTmpl($viewName, array $params = array())
    {
        $__content = null;
        $__path    = App::cleanPath(P_TMPL . '/' . $viewName . '.php');

        if (file_exists($__path)) {
            ob_start();
            extract($params);
            include $__path;
            $__content = ob_get_contents();
            ob_end_clean();
        }

        return $__content;
    }

    /**
     * @param $bytes
     * @return string
     */
    public static function formatFilesize($bytes)
    {
        $exp    = 0;
        $value  = 0;
        $symbol = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

        if ($bytes > 0) {
            $exp   = floor(log($bytes) / log(1024));
            $value = ($bytes / pow(1024, floor($exp)));
        }

        return sprintf('%.2f ' . $symbol[$exp], $value);
    }

    /**
     *
     */
    static public function getRootUrl($addAuth = false)
    {
        $relPath = str_replace('\\', '/', pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME));

        $scheme = 'http';
        if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) {
            $scheme = 'https';
        }

        $user = null;
        if (isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER']) {
            $user = $_SERVER['PHP_AUTH_USER'];
        }

        $pass = null;
        if (isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW']) {
            $pass = $_SERVER['PHP_AUTH_PW'];
        }

        $uri = '';
        $uri .= $scheme . '://';

        if ($addAuth) {
            $uri .= $user ? $user : '';
            $uri .= (!empty($pass) ? ':' : '') . $pass . (!empty($user) ? '@' : '');
        }

        $uri .= $_SERVER['HTTP_HOST'];
        $uri .= $_SERVER['SERVER_PORT'] != '80' ? ':' . $_SERVER['SERVER_PORT'] : '';
        $uri .= !empty($relPath) ? $relPath : '/';

        return $uri;
    }

}
