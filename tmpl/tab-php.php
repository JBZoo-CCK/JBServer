<?php

$helper = new AppPHP();

?>
<div class="row">
    <div class="col-md-6">
        <h4>Важные настройки PHP</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Memory limit', $helper->getParam('memory_limit', 'bytes')),
            array('Max execution time', $helper->getParam('max_execution_time', 'int')),
            array('Max input time', $helper->getParam('max_input_time', 'int')),
            array('Post max size', $helper->getParam('post_max_size', 'bytes')),
        ))); ?>
        <h4>Загрузка файлов</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('File uploads', $helper->getParam('file_uploads', 'bool')),
            array('Upload tmp dir', $helper->getParam('upload_tmp_dir', 'path')),
            array('Upload max filesize', $helper->getParam('upload_max_filesize', 'bytes')),
            array('Max file uploads', $helper->getParam('max_file_uploads', 'int')),
        ))); ?>
    </div>
    <div class="col-md-6">
        <h4>Настройки PHP сессий</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Name', $helper->getParam('session.name')),
            array('Auto  start', $helper->getParam('session.auto_start', 'bool')),
            array('Save path', $helper->getParam('session.save_path', 'path')),
            array('Save handler', $helper->getParam('session.save_handler')),
            array('Use trans sid', $helper->getParam('session.use_trans_sid', 'bool')),
            array('Cache limiter', $helper->getParam('session.cache_limiter')),
        ))); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h4>Некоторые настройки безопасности</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Safe mode', $helper->getParam('safe_mode', 'bool')),
            array('Command line functions', $helper->checkCommandLine()),
            array('Disable functions', $helper->getDisableFunctions()),
            array('Register globals', $helper->getParam('register_globals', 'bool')),
            array('Disable classes', $helper->getDisabledClasses()),
            array('Allow url fopen', $helper->getParam('allow_url_fopen', 'bool')),
            array('Magic quotes', $helper->getParam('magic_quotes_gpc', 'bool')),
            array('Max input vars', $helper->getParam('max_input_vars', 'int')),
            array('Document root (php)', $helper->getParam('doc_root', 'path')),
            array('Open basedir', $helper->getOpenBasedir()),
            array('Expose php', $helper->getParam('expose_php', 'bool')),
        ))); ?>
    </div>
    <div class="col-md-6">
        <h4>Вывод ошибок</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Error reporting', $helper->getParam('error_reporting', 'error')),
            array('Display errors', $helper->getParam('display_errors', 'bool')),
            array('Display startup errors', $helper->getParam('display_startup_errors', 'bool')),
            array('Log errors', $helper->getParam('log_errors', 'bool')),
            array('Error log path', $helper->getParam('error_log', 'path')),
            array('Log errors max length', $helper->getParam('log_errors_max_len', 'int')),
            array('Report memleaks', $helper->getParam('report_memleaks', 'bool')),
            array('Ignore repeated errors', $helper->getParam('ignore_repeated_errors', 'bool')),
            array('Ignore repeated source', $helper->getParam('ignore_repeated_source', 'bool')),
        ))); ?>
    </div>
    <div class="col-md-12">
        <h4>Разное</h4>
        <?php echo AppWidget::renderTable(array('rows' => array(
            array('Short open tag', $helper->getParam('short_open_tag', 'bool')),
            array('Realpath cache size', $helper->getParam('realpath_cache_size', 'bytes')),
            array('Realpath cache ttl', $helper->getParam('realpath_cache_ttl', 'int')),
            array('Prepend file', $helper->getParam('auto_prepend_file', 'path')),
            array('Append file', $helper->getParam('auto_append_file', 'path')),
            array('Arg separator (input)', $helper->getParam('arg_separator.input')),
            array('Arg separator (output)', $helper->getParam('arg_separator.output')),
            array('Auto detect line endings', $helper->getParam('auto_detect_line_endings', 'bool')),
            array('Date timezone', $helper->getParam('date.timezone')),
            array('Default charset', $helper->getParam('default_charset')),
            array('Output buffering', $helper->getParam('output_buffering')),
            array('Output compression(zlib)', $helper->getParam('zlib.output_compression')),
            array('Implicit flush', $helper->getParam('implicit_flush')),
            array('Ignore user abort', $helper->getParam('ignore_user_abort', 'bool')),
        ))); ?>
    </div>
</div>

