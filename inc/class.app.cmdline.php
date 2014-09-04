<?php


class AppCommandline
{
    protected $_isDebug = false;

    /**
     * Constrictor
     */
    function __construct($rootPath = null)
    {
        if (!$rootPath) {
            if (isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) {
                $rootPath = $_SERVER['DOCUMENT_ROOT'];
            }
        }

        $this->chdir($rootPath);
    }

    /**
     * Exec console command
     * @param string $cmd
     * @param string $toFile
     * @return null|string
     */
    public function exec($cmd, $toFile = null)
    {
        if ($toFile) {
            $cmd .= " > " . $toFile;
        }

        $read = null;

        $this->_log($cmd, 'exec/start');
        if (checkFn('shell_exec')) {
            $read = shell_exec($cmd);

        } else if (checkFn('exec')) {
            exec($cmd, $read);
            $read = implode("\n", $read);

        } else if (checkFn('system')) {
            ob_start();
            system($cmd);
            $read = ob_get_contents();
            ob_end_clean();

        } else if (checkFn(array('popen', 'fread', 'pclose'))) {
            $handle = popen($cmd, "r");
            $read   = fread($handle, 16384);
            pclose($handle);
        }
        $this->_log($read, 'exec/result');

        return $read;
    }

    /**
     * Set debug mode
     * @param $mode
     */
    public function debugMode($mode = true)
    {
        $this->_isDebug = (int)$mode;
    }

    /**
     * @param string $message
     * @param string $action
     * @return void
     */
    protected function _log($message, $action = null)
    {
        if (!$this->_isDebug) {
            return;
        }

        if (class_exists('jbdump')) {
            jbdump::log(trim($message), __CLASS__ . " -> " . $action);
        }
    }

    /**
     * @param array $arguments
     * @return null|string
     */
    protected function _buildArgs($arguments)
    {
        $arguments = (array)$arguments;

        if (!empty($arguments)) {
            return ' ' . implode(' ', $arguments);
        }

        return null;
    }

    /**
     * @param $newPath
     * @return bool
     */
    public function chdir($newPath)
    {
        if ($newPath) {
            return chdir($newPath);
        }

        return null;
    }

    /**
     * read system file
     * @param $path
     * @return string
     */
    public function catFile($path)
    {
        if (App::$isWin) {
            return null;
        }

        $result = $this->exec('cat ' . $path);

        if (!$result) {

            if (checkFn(array('fopen', 'fread')) && @file_exists($path)) {

                $file = fopen($path, 'r');
                if (!$file) {
                    $this->_log('Opening of ' . $path . ' failed!');
                    return null;
                }

                $data = fread($file, 4096);
                if ($data === false) {
                    $this->_log('fread() failed on  ' . $path);
                }
            }
        }

        return $result;
    }

}