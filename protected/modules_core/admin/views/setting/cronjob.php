<h1><?php echo Yii::t('AdminModule.cron', 'CronJob - Settings'); ?></h1>

<p>
    <strong>Status:</strong><br />
    <?php
    $lastRunHourly = HSetting::get('cronLastHourlyRun');
    $lastRunDaily = HSetting::get('cronLastDailyRun');

    if ($lastRunHourly == "") {
        $lastRunHourly = "<span style='color:red'>".Yii::t('AdminModule.cron', 'Never'). "</span>";
    } else{
        $lastRunHourly = HHtml::timeago($lastRunHourly);
    }
    if ($lastRunDaily== "") {
        $lastRunDaily = "<span style='color:red'>".Yii::t('AdminModule.cron', 'Never'). "</span>";
    } else{
        $lastRunDaily = HHtml::timeago($lastRunDaily);
    }
    ?>

    <?php echo Yii::t('AdminModule.cron', 'Last run (hourly):'); ?> <?php echo $lastRunHourly; ?> <br />
    <?php echo Yii::t('AdminModule.cron', 'Last run (daily):'); ?> <?php echo $lastRunDaily; ?>
</p>

<p><?php echo Yii::t('AdminModule.cron', 'Please make sure following cronjobs are installed:'); ?></p>
<pre>

<strong><?php echo Yii::t('AdminModule.cron', 'Crontab of user: {user}', array('{user}'=>get_current_user())); ?></strong>
30 * * * * <?php echo Yii::app()->getBasePath(); ?>/yiic cron hourly >/dev/null 2>&1
00 18 * * * <?php echo Yii::app()->getBasePath(); ?>/yiic cron daily >/dev/null 2>&1

<strong><?php echo Yii::t('AdminModule.cron', 'Or Crontab of root user'); ?></strong>
*/5 * * * * su -c "<?php echo Yii::app()->getBasePath(); ?>/yiic cron hourly" <?php echo get_current_user(); ?> >/dev/null 2>&1
0 18 * * * su -c "<?php echo Yii::app()->getBasePath(); ?>/yiic cron daily" <?php echo get_current_user(); ?> >/dev/null 2>&1

</pre>
