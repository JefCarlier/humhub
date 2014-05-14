<?php

/**
 * AdminController provides all space administration actions.
 *
 * @author Luke
 * @package humhub.modules_core.space.controllers
 * @since 0.5
 */
class AdminController extends Controller {

    /**
     * @var String Admin Sublayout
     */
    public $subLayout = "application.modules_core.space.views.admin._layout";

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Add mix-ins to this model
     *
     * @return type
     */
    public function behaviors() {
        return array(
            'ProfileControllerBehavior' => array(
                'class' => 'application.modules_core.space.SpaceControllerBehavior',
            ),
        );
    }

    /**
     * First Admin Action to display
     */
    public function actionIndex() {
        $this->redirect($this->createUrl('edit', array('sguid' => $this->getSpace()->guid)));
    }

    /**
     * Space Edit Form
     *
     * @todo Add Owner Switch Box for the Owner only!
     */
    public function actionEdit() {

        $this->adminOnly();

        $model = $this->getSpace();
        $model->scenario = 'edit';

        // When Sidebar is build, attach ChangeImage Widget
        Yii::app()->interceptor->preattachEventHandler('SpaceSidebarWidget', 'onInit', function($event) {
            $event->sender->addWidget('application.modules_core.space.widgets.SpaceChangeImageWidget', array(), array('sortOrder' => 10));
        });

        // Ajax Validation
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'space-edit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Space'])) {
            $_POST['Space'] = Yii::app()->input->stripClean($_POST['Space']);

            $model->attributes = $_POST['Space'];

            if ($model->validate()) {
                $model->save();

                // set flash message
                Yii::app()->user->setFlash('data-saved', Yii::t('base', 'Saved'));

                $this->redirect($this->createUrl('admin/edit', array('sguid' => $this->getSpace()->guid)));
            }
        }

        $this->render('edit', array('model' => $model, 'space' => $model));
    }

    /**
     * Members Administration Action
     */
    public function actionMembers() {

        $this->adminOnly();

        $membersPerPage = 10;
        $workspace = $this->getSpace();

        // User Role Management
        if (isset($_POST['users'])) {

            $users = Yii::app()->request->getParam('users');

            // Loop over all users in Form
            foreach ($users as $userGuid) {

                // Get informations
                if (isset($_POST['user_' . $userGuid])) {
                    $userSettings = Yii::app()->request->getParam('user_' . $userGuid);

                    $user = User::model()->findByAttributes(array('guid' => $userGuid));
                    if ($user != null) {

                        // No changes on the Owner
                        if ($workspace->isOwner($user->id))
                            continue;

                        $membership = SpaceMembership::model()->findByAttributes(array('user_id' => $user->id, 'space_id' => $workspace->id));
                        if ($membership != null) {
                            $membership->invite_role = (isset($userSettings['inviteRole']) && $userSettings['inviteRole'] == 1) ? 1 : 0;
                            $membership->admin_role = (isset($userSettings['adminRole']) && $userSettings['adminRole'] == 1) ? 1 : 0;
                            $membership->share_role = (isset($userSettings['shareRole']) && $userSettings['shareRole'] == 1) ? 1 : 0;
                            $membership->save();
                        }
                    }

                    // Change owner if changed
                    if ($workspace->isOwner()) {
                        $owner = $workspace->getOwner();

                        $newOwnerId = Yii::app()->request->getParam('ownerId');

                        if ($newOwnerId != $owner->id) {
                            if ($workspace->isMember($newOwnerId)) {
                                $workspace->setOwner($newOwnerId);

                                // Redirect to current workspace
                                $this->redirect($this->createUrl('admin/members', array('sguid' => $this->getSpace()->guid)));
                            }
                        }
                    }
                }
            } // Loop over Users

            // set flash message
            Yii::app()->user->setFlash('data-saved', Yii::t('base', 'Saved'));

        } // Updated Users


        $criteria = new CDbCriteria;
        $criteria->condition = "1";

        // Allow User Searches
        $search = Yii::app()->request->getQuery('search');
        if ($search != "") {
            $criteria->join = "LEFT JOIN user ON memberships.user_id = user.id ";
            $criteria->condition .= " AND (";
            $criteria->condition .= ' user.username LIKE :search';
            $criteria->condition .= ' OR user.email like :search';
            $criteria->condition .= " ) ";
            $criteria->params = array(':search' => '%' . $search . '%');
        }

        //ToDo: Better Counting
        $allMemberCount = count($workspace->memberships($criteria));

        $pages = new CPagination($allMemberCount);
        $pages->setPageSize($membersPerPage);
        $pages->applyLimit($criteria);

        $members = $workspace->memberships($criteria);

        $this->render('members', array(
            'workspace' => $workspace,
            'members' => $members, // must be the same as $item_count
            'item_count' => $allMemberCount,
            'page_size' => $membersPerPage,
            'search' => $search,
            'pages' => $pages,
        ));
    }

    /**
     * User Manage Users Page, Reject Member Request Link
     */
    public function actionAdminMembersRejectApplicant() {
        $this->adminOnly();

        $space = $this->getSpace();
        $userGuid = Yii::app()->request->getParam('userGuid');
        $user = User::model()->findByAttributes(array('guid' => $userGuid));

        if ($user != null) {
            $space->removeMember($user->id);
            SpaceApprovalRequestDeclinedNotification::fire(Yii::app()->user->id, $user, $space);
        }

        $this->redirect($space->getUrl());
    }

    /**
     * User Manage Users Page, Approve Member Request Link
     */
    public function actionAdminMembersApproveApplicant() {
        $this->adminOnly();

        $space = $this->getSpace();
        $userGuid = Yii::app()->request->getParam('userGuid');
        $user = User::model()->findByAttributes(array('guid' => $userGuid));

        if ($user != null) {
            $membership = $space->getMembership($user->id);
            if ($membership != null && $membership->status == SpaceMembership::STATUS_APPLICANT) {
                $space->addMember($user->id);
            }
        }


        $this->redirect($space->getUrl());
    }

    /**
     * Removes a Member
     *
     */
    public function actionAdminRemoveMember() {

        $this->adminOnly();

        $workspace = $this->getSpace();
        $userGuid = Yii::app()->request->getParam('userGuid');
        $user = User::model()->findByAttributes(array('guid' => $userGuid));

        if ($workspace->isOwner($user->id)) {
            throw new CHttpException(500, 'Owner cannot be removed!');
        }

        $workspace->removeMember($user->id);

        // Redirect  back to Administration page
        $this->htmlRedirect($this->createUrl('//space/admin/members', array('sguid' => $workspace->guid)));
    }

    /**
     * Set a Profile Image
     *
     */
    public function actionChangeImage() {

        $this->adminOnly();

        $model = new UploadProfileImageForm();
        $workspace = $this->getSpace();

        if (isset($_POST['UploadProfileImageForm'])) {

            $_POST['UploadProfileImageForm'] = Yii::app()->input->stripClean($_POST['UploadProfileImageForm']);

            $model->attributes = $_POST['UploadProfileImageForm'];

            $model->image = CUploadedFile::getInstance($model, 'image');

            if ($model->validate()) {

                $profileImage = new ProfileImage($workspace->guid);
                $profileImage->setNew($model->image);

                $this->redirect($this->createUrl('//space/admin/cropImage', array('sguid' => $workspace->guid)));
            }
        }

        $this->render('changeImage', array('model' => $model, 'workspace' => $workspace));
    }

    /**
     * Set a Profile Image
     *
     */
    public function actionCropImage() {

        $this->adminOnly();

        $workspace = $this->getSpace();

        $model = new CropProfileImageForm;
        $profileImage = new ProfileImage($workspace->guid);

        if (isset($_POST['CropProfileImageForm'])) {

            $model->attributes = $_POST['CropProfileImageForm'];

            if ($model->validate()) {
                $profileImage->cropOriginal($model->cropX, $model->cropY, $model->cropH, $model->cropW);
                $this->redirect($this->createUrl('//space/admin/edit', array('sguid' => $workspace->guid)));
            }
        }

        $this->render('cropImage', array('model' => $model, 'profileImage' => $profileImage, 'workspace' => $workspace));
    }

    /**
     * Deletes the Profile Image
     */
    public function actionDeleteImage() {

        $this->adminOnly();
        $space = $this->getSpace();
        $space->getProfileImage()->delete();
        $this->redirect($this->createUrl('//space/admin/edit', array('sguid' => $space->guid)));
    }

    /**
     * Modules Administration Action
     */
    public function actionModules() {

        $this->adminOnly();
        $space = $this->getSpace();

        if (Yii::app()->request->getParam('submitted') == 1) {

            $modules = Yii::app()->request->getParam('module', array());

            foreach ($workspace->getAvailableModules() as $moduleId => $moduleInfo) {

                if (!array_key_exists($moduleId, $modules) && $workspace->isModuleEnabled($moduleId)) {
                    $workspace->uninstallModule($moduleId);
                } elseif (array_key_exists($moduleId, $modules) && !$workspace->isModuleEnabled($moduleId)) {
                    $workspace->installModule($moduleId);
                }
            }
        }

        $this->render('modules');
    }

    public function actionEnableModule() {

        $space = $this->getSpace();
        $moduleId = Yii::app()->request->getParam('moduleId', "");

        if (!$this->getSpace()->isModuleEnabled($moduleId)) {
            $this->getSpace()->installModule($moduleId);
        }

        $this->redirect($this->createUrl('admin/modules', array('sguid' => $this->getSpace()->guid)));
    }

    public function actionDisableModule() {

        $space = $this->getSpace();
        $moduleId = Yii::app()->request->getParam('moduleId', "");

        if ($this->getSpace()->isModuleEnabled($moduleId)) {
            $this->getSpace()->uninstallModule($moduleId);
        }

        $this->redirect($this->createUrl('admin/modules', array('sguid' => $this->getSpace()->guid)));
    }

    /**
     * Archives a workspace
     */
    public function actionArchive() {
        $this->ownerOnly();
        $space = $this->getSpace();
        $space->archive();
        $this->htmlRedirect($this->createUrl('//space/admin/edit', array('sguid' => $space->guid)));
    }

    /**
     * UnArchives a workspace
     */
    public function actionUnArchive() {
        $this->ownerOnly();
        $space = $this->getSpace();
        $space->unarchive();
        $this->htmlRedirect($this->createUrl('//space/admin/edit', array('sguid' => $space->guid)));
    }

    /**
     * Deletes this Space
     */
    public function actionDelete() {
        $this->ownerOnly();
        $space = $this->getSpace();
        $model = new SpaceDeleteForm;
        if (isset($_POST['SpaceDeleteForm'])) {
            $model->attributes = $_POST['SpaceDeleteForm'];

            if ($model->validate()) {
                $space->delete();
                $this->htmlRedirect($this->createUrl('//'));
            }
        }
        $this->render('delete', array('model' => $model, 'space' => $space));
    }

    /**
     * Request only allowed for workspace admins
     */
    public function adminOnly() {
        if (!$this->getSpace()->isAdmin())
            throw new CHttpException(403, 'Access denied - Space Administrator only!');
    }

    /**
     * Request only allowed for workspace owner
     */
    public function ownerOnly() {
        $workspace = $this->getSpace();

        if (!$workspace->isOwner() && !Yii::app()->user->isAdmin())
            throw new CHttpException(403, 'Access denied - Space Owner only!');
    }

}

?>
