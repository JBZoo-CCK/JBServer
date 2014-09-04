<?php

$testUrl = App::getRootUrl();
$reportUrl = App::getRootUrl();
$helper = new AppBenchmark();

$testList = $helper->getTestData();

?>

<pre>
    проверка прав файловой системы
    создание tmp на ходу
</pre>

<h2><?php echo _t('benchmark_title'); ?></h2>
<p><?php echo _t('benchmark_info_performance_desc'); ?></p>
<p><?php echo _t('benchmark_info_performance_website_1'); ?></p>
<p><em><?php echo _t('benchmark_info_performance_website_2'); ?></em></p>

<a class="btn btn-warning jsStart"
   href="<?php echo $testUrl; ?>"><?php echo _t('benchmark_info_performance_start'); ?></a>
<a class="btn btn-success jsReport"
   href="<?php echo $reportUrl; ?>"><?php echo _t('benchmark_info_performance_share'); ?></a>

<p>&nbsp;</p>

<table class="table table-hover table-performance">
    <thead>
    <tr>
        <th class="col-md-6"><?php echo _t('benchmark_info_performance_testname'); ?></th>
        <th class="col-md-3 text-center"><?php echo _t('benchmark_info_performance_current'); ?></th>
        <th class="col-md-3 text-center"><?php echo _t('benchmark_info_performance_standart'); ?></th>
    </tr>
    </thead>

    <tbody>

    <?php foreach ($testList as $group => $tests) : ?>
        <tr>
            <td colspan="4">
                <h4 style="color:#a00;"><em><?php echo _t('benchmark_' . $group); ?></em></h4>
                <?php echo _t('benchmark_' . $group . '_desc'); ?>
            </td>
        </tr>
        <?php foreach ($tests as $test) :

            $isAlert = '';
            if ($test['value'] != '-') {
                $isAlert = $helper->isAlert($test['value'], $test['key']);
                if ($isAlert !== -1) {
                    $isAlert = ($isAlert) ? 'uk-error' : 'uk-success';
                }
            }

            ?>
            <tr class="jstest jstest-<?php echo $test['key']; ?> <?php echo $isAlert; ?>"
                data-testname="<?php echo $test['key']; ?>">
                <td>
                    <strong class="testname"><?php echo _t('benchmark_' . $test['key']); ?></strong><br>
                    <?php echo _t('benchmark_' . $test['key'] . '_desc'); ?>
                </td>

                <td class="text-center jsValue">
                    <?php echo $helper->toFormat($test['value'], $test['key']); ?>
                </td>

                <td class="text-center jsStandard">
                    <?php echo $helper->toFormat($test['standart'], $test['key']); ?>

                    <?php if ($test['postfix']) : ?>
                        <?php echo _t('benchmark_postfix_' . $test['postfix']); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>

    <?php endforeach; ?>

    </tbody>
</table>

<h3><em><?php echo _t('benchmark_disclaimer_title'); ?></em></h3>

<ul>
    <li><?php echo _t('benchmark_info_performance_1'); ?></li>
    <li><?php echo _t('benchmark_info_performance_2'); ?></li>
    <li><?php echo _t('benchmark_info_performance_3'); ?></li>
    <li><?php echo _t('benchmark_info_performance_4'); ?></li>
    <li><?php echo _t('benchmark_info_performance_5'); ?></li>
    <li><?php echo _t('benchmark_info_performance_6'); ?></li>
    <li><?php echo _t('benchmark_info_performance_7'); ?></li>
    <li><?php echo _t('benchmark_info_performance_8'); ?></li>
</ul>


<script type="text/javascript">
    jQuery(function ($) {

        var requestUrl = "<?php echo $testUrl;?>";

        var img = '<img src="assets/loader.gif" />';

        var execTest = function (i) {

            var date = new Date(),
                $obj = $('.jstest:eq(' + i + ')'),
                testName = $obj.data('testname'),
                $value = $('.jsValue', $obj),
                $standard = $('.jsStandard', $obj);

            $value.html(img);

            $.ajax({
                'dataType': 'json',
                'type'    : 'GET',
                'cache'   : false,
                'headers' : {
                    "cache-control": "no-cache"
                },
                'url'     : requestUrl,
                'data'    : {
                    'task'    : 'exectest',
                    'testname': testName
                },
                'success' : function (data) {

                    if (typeof (data.value) != "undefined") {
                        $value.text(data.value);
                        $standard.text(data.standart);

                        if (data.alert == -1) {
                            $obj.removeClass('danger warning success');
                        } else {
                            $obj.toggleClass('warning', data.alert);
                            $obj.toggleClass('success', !data.alert);
                        }
                    } else {
                        $value.text('FAIL!');
                        $obj.toggleClass('danger', true);
                    }

                    i++;
                    var $nextTest = $('.jstest:eq(' + i + ')');
                    if ($nextTest.length != 0) {
                        // no hardcore!
                        setTimeout(function () {
                            execTest(i);
                        }, 500);
                    }
                },
                'error'   : function (data) {
                    $value.text('FATAL ERROR!');

                    alert(data.responseText);
                }
            });
        }

        $('.jsStart').click(function () {
            $('.jstest').removeClass('error success');
            execTest(0);
            return false;
        });

        $('.jsReport').click(function () {

        });

    });
</script>

<style>
    .jstest-total_score .jsValue {
        font-weight: bold;
        color: #a00;
        font-size: 200%;
    }
</style>