<?php $this->beginContent('application.modules_core.activity.views.activityLayout', array('activity' => $activity)); ?>                    

<strong><?php echo $user->displayName; ?></strong>
<?php echo Yii::t('PollsModule.base', 'created a new poll'); ?> "<i><?php echo Helpers::truncateText($target->question, 25); ?></i>".

<?php $this->endContent(); ?>

