<?php

$helper = new AppEnv();

$crontab = $helper->getCrontabList();
$tasklist = $helper->getTaskList();

?>

<div class="row">
    <div class="col-md-12">
        <h4>Пути</h4>
        <?php echo AppWidget::renderTable(array(
            'params' => array('wrap' => 'code'),
            'rows'   => array(
                array('Document root', $_SERVER['DOCUMENT_ROOT']),
                array('Environment PATH', implode('<br>', $helper->getEnvironmentPaths())),
                array('PHP include path', implode('<br>', $helper->getIncludedPaths())),
                array('Script path', $_SERVER['SCRIPT_FILENAME']),
                array('Script path (real)', realpath($_SERVER['SCRIPT_FILENAME'])),
            )));?>
    </div>
</div>

<?php if ($crontab) : ?>
    <h4>Список задач в crontab</h4>
    <pre><?php echo $crontab; ?></pre>
<?php endif; ?>

<?php if ($tasklist) : ?>
    <h4>Текущий список процессов</h4>
    <pre><?php echo $tasklist; ?></pre>
<?php endif; ?>
