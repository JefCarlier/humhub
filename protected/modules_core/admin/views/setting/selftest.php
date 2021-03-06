<h1><?php echo Yii::t('AdminModule.base', 'Self Test'); ?></h1>

<p><?php echo Yii::t('AdminModule.base', 'Checking HumHub software prerequisites.'); ?></p>

<div class="well">

    <ul>

        <?php foreach ($checks as $check): ?>
            <li>
                <strong><?php echo $check['title']; ?>:</strong>

                <?php if ($check['state'] == 'OK') : ?>
                    <span style="color:green">Ok!</span>
                <?php elseif ($check['state'] == 'WARNING') : ?>
                    <span style="color:orange">Warning!</span>
                <?php else : ?>
                    <span style="color:red">Error!</span>
                <?php endif; ?>

                <?php if (isset($check['hint'])): ?>
                    <span>(Hint: <?php echo $check['hint']; ?>)</span>
                <?php endif; ?>

            </li>
        <?php endforeach; ?>


    </ul>


</div>
<br>


<div class="well">
    <?php echo $migrate; ?>
</div>
<hr>

<?php echo HHtml::link(Yii::t('AdminModule.base', 'Re-Run tests'), array('//admin/setting/selftest'), array('class' => 'btn btn-primary')); ?>



