<?php $this->beginContent('application.modules_core.notification.views.notificationLayout', array('notification' => $notification, 'iconClass' => 'icon-remove-sign approval declined')); ?>
<?php echo Yii::t('SpaceModule.notifications', '{userName} declined your membership request in {spaceName}', array('{userName}' => '<strong>' . $creator->displayName . '</strong>', '{spaceName}' => '<strong>' . $targetObject->name . '</strong>')); ?> 
<?php $this->endContent(); ?>
