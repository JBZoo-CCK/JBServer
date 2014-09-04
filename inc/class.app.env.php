<?php

class AppEnv
{

    /**
     * @return mixed|null|string
     */
    public function getTaskList()
    {
        $cmdLine = new AppCommandline();

        if (strtolower(PHP_OS) == 'darwin') {
            $result = $cmdLine->exec("top -l 1");

        } else {
            $result = $cmdLine->exec("top -b -n 1");
        }

        $result = str_replace(" ", "&nbsp;", $result);

        return $result;
    }

    /**
     * @return null|string
     */
    public function getCrontabList()
    {
        if (!App::$isWin) {
            $cmdLine = new AppCommandline();
            return $cmdLine->exec('crontab -l');
        }

        return null;
    }

    /**
     * @return array
     */
    public function getIncludedPaths()
    {
        $paths = explode(PATH_SEPARATOR, get_include_path());
        $paths = array_filter($paths);
        return $paths;
    }

    /**
     * @return array
     */
    public function getEnvironmentPaths()
    {
        $paths = explode(PATH_SEPARATOR, trim($_SERVER['PATH']));
        $paths = array_filter($paths);
        return $paths;
    }

    /**
     * @return bool
     */
    public function prepareHtacces()
    {
        $testPath = App::cleanPath(P_TMP . '/htaccess_test');
        $fileHt   = App::cleanPath($testPath . '/.htaccess');
        $file404  = App::cleanPath($testPath . '/test_404.php');

        // remove old test files
        if (file_exists($fileHt)) {
            unlink($fileHt);
            unlink($file404);
            rmdir($testPath);
        }

        if (!is_dir($testPath)) {
            mkdir($testPath, 0777, true);
        }

        // create htaccess file
        $content = implode("\n", array(
            'ErrorDocument 404 ' . $file404,
            '<IfModule mod_rewrite.c>',
            '   RewriteEngine Off',
            '</IfModule>'
        ));

        @file_put_contents($fileHt, $content);
        if (!file_exists($fileHt)) {
            return 'Cannot create ' . $fileHt;
        }

        // create 404 file handler
        $content = implode("\n", array(
            '<?php ',
            'header("HTTP/1.1 200 OK");',
            'echo "ok";'
        ));

        @file_put_contents($file404, $content);
        if (!file_exists($file404)) {
            return 'Cannot create ' . $file404;
        }

        $url = App::getRootUrl(true) . '/htaccess_test/test_404.php';
//        dump(file_get_contents($url));

        return true;
    }


}