<?php

/**
 * The Admin Navigation for spaces
 *
 * @author Luke
 * @package humhub.modules_core.space.widgets
 * @since 0.5
 */
class SpaceAdminMenuWidget extends MenuWidget {

    public $template = "application.widgets.views.leftNavigation";

    public function init() {

// Reckon the current controller is a valid space controller
// (Needs to implement the SpaceControllerBehavior)
        $spaceGuid = Yii::app()->getController()->getSpace()->guid;
        $space = Yii::app()->getController()->getSpace();


        $this->addItemGroup(array(
            'id' => 'admin',
            'label' => Yii::t('SpaceModule.base', 'Space preferences'),
            'sortOrder' => 100,
        ));

        // check user rights
        if ($space->isAdmin()) {
            $this->addItem(array(
                'label' => Yii::t('SpaceModule.base', 'Basic'),
                'group' => 'admin',
                'url' => Yii::app()->createUrl('//space/admin/edit', array('sguid' => $spaceGuid)),
                'icon' => '<i class="icon-cogs"></i>',
                'sortOrder' => 100,
                'isActive' => (Yii::app()->controller->id == "admin" && Yii::app()->controller->action->id == "edit"),
            ));
        }

        // check user rights
        if ($space->canInvite()) {
            $this->addItem(array(
                'label' => Yii::t('SpaceModule.base', 'Members'),
                'group' => 'admin',
                'url' => Yii::app()->createUrl('//space/admin/members', array('sguid' => $spaceGuid)),
                'icon' => '<i class="icon-group"></i>',
                'sortOrder' => 200,
                'isActive' => (Yii::app()->controller->id == "admin" && Yii::app()->controller->action->id == "members"),
            ));
        }

        // check user rights
        if ($space->isAdmin()) {
            $this->addItem(array(
                'label' => Yii::t('SpaceModule.base', 'Modules'),
                'group' => 'admin',
                'url' => Yii::app()->createUrl('//space/admin/modules', array('sguid' => $spaceGuid)),
                'icon' => '<i class="icon-rocket"></i>',
                'sortOrder' => 300,
                'isActive' => (Yii::app()->controller->id == "admin" && Yii::app()->controller->action->id == "modules"),
            ));
        }

#        $this->addItem(array(
#            'label' => Yii::t('SpaceModule.base', 'Archive'),
#            'url' => Yii::app()->createUrl('//space/admin/archive', array('sguid'=>$spaceGuid)),
#            'sortOrder' => 400,
#            'isActive' => (Yii::app()->controller->id == "admin" && Yii::app()->controller->action->id == "archive"),
#        ));
#        $this->addItem(array(
#            'label' => Yii::t('SpaceModule.base', 'Delete'),
#            'url' => Yii::app()->createUrl('//space/admin/delete', array('sguid'=>$spaceGuid)),
#            'sortOrder' => 500,
#            'isActive' => (Yii::app()->controller->id == "admin" && Yii::app()->controller->action->id == "delete"),
#        ));
#        $this->addItem(array(
#            'label' => Yii::t('SpaceModule.base', 'Back to workspace'),
#            'url' => Yii::app()->createUrl('//space/space', array('sguid'=>$spaceGuid)),
#            'sortOrder' => 1000,
#        ));


        parent::init();
    }

}

?>
