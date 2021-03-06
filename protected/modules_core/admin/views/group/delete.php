<?php
/**
 * Delete View of a group
 *
 * @property Group $group the group object to delete
 * @property AdminDeleteGroupForm $model is the model of the deletion form
 *
 * @todo Cleanup Group View
 * @todo Add Back Button
 *
 * @package humhub.modules_core.admin
 * @since 0.5
 */
?>

<p>
<?php echo Yii::t('AdminModule.base', 'To delete the group <strong>"{group}"</strong> you need to set an alternative group for existing users:', array('{group}' => $group->name)); ?>
</p>




<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'admin-deleteGroup-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>

<?php echo $form->errorSummary($model); ?>


    <?php
    $groupModels = Group::model()->findAll('id !=' . $group->id);
    $list = CHtml::listData($groupModels, 'id', 'name');
    ?>

<div class="form-group">
    <?php echo $form->dropDownList($model, 'group_id', $list, array('class' => 'form-control')); ?>
    <?php echo $form->error($model, 'group_id'); ?>
</div>




<hr>
<?php echo CHtml::submitButton(Yii::t('AdminModule.base', 'Delete group'), array('class' => 'btn btn-danger')); ?>



<?php $this->endWidget(); ?>






