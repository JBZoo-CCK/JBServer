<!DOCTYPE html>
<html>
<head>
    <title>JBHostChecker by userSmile</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

    <!--<link rel="shortcut icon" type="image/x-icon" href="?task=assets&file=favicon.ico">-->
    <!--<link rel="apple-touch-icon" href="?task=assets&file=favicon.ico">-->
    <style>
        body {
            padding-top: 50px;
            overflow-y: scroll !important;
        }

        #wrap {
            margin-top: 36px;
        }

        #tab-phpinfo .v {
            max-width: 40%;
        }

        #tab-phpinfo .e {
            width: 50%;
        }
        h4 {
            font-style: italic;
            color: #a00;
            margin-top: 20px;
        }

    </style>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand">JBHostChecker</span>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <!--<li class="active"><a href="http://jbzoo.com/">Home</a></li>-->
                <!--<li><a href="http://jbzoo.com/"></a></li>-->
            </ul>
        </div>
    </div>
</div>

<div id="wrap">
    <div class="container">

        <?php
        $tabs = array(
            'phpmodules' => 'PHP Modules',

            'overview'   => 'Overview',
            'env'        => 'Environment',
            'php'        => 'PHP',
            'mysql'      => 'MySQL',
            'filesystem' => 'Filesystem',
            'benchmark'  => 'Benchmark',
            'tools'      => 'Tools',
            'phpinfo'    => 'phpinfo()',
            'config'     => 'Config',
            'advice'     => 'Great advices =)',
        );

        $html = $bodyList = $headerList = array();
        foreach ($tabs as $tabKey => $tabName) {
            $headerList[] = '<li><a data-toggle="tab" href="#tab-' . $tabKey . '">' . $tabName . '</a></li>';
            $bodyList[]   = '<div class="tab-pane" id="tab-' . $tabKey . '">' . App::renderTmpl('tab-' . $tabKey) . '</div>';
        }

        $html[] = '<ul class="nav nav-tabs" id="tabs">' . implode("\n ", $headerList) . '</ul>';
        $html[] = '<div class="tab-content">' . implode("\n ", $bodyList) . '</div>';

        echo implode("\n ", $html);
        ?>

        <hr/>
        <p><em style="color:#a00;">** Если на сервере есть доступ к командной строке из PHP и подключение к базе данных,
                то вам будет доступно больше информации о системе.</em></p>
        <hr/>

        <footer>
            <p>2014 by <a href="http://usersmile.com">userSmile</a> // <a href="http://smetdenis.com/">Denis.Smetannikov</a></p>
        </footer>
    </div>
</div>

<script type="text/javascript">
    $(function () {

        // init bootstrap tabs
        $('.nav-tabs').each(function (n, obj) {
            $('a', obj).click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $('a:first', obj).tab('show');
        });

        $('.tooltip').tooltip();
    });
</script>

</body>
</html>
