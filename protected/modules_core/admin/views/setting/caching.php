<h1><?php echo Yii::t('AdminModule.base', 'Cache - Settings'); ?></h1><br>
<?php   $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cache-settings-form',
    'enableAjaxValidation' => false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'type'); ?>
    <?php echo $form->dropDownList($model, 'type', $cacheTypes, array('class' => 'form-control','readonly'=>  HSetting::IsFixed('type', 'cache'))); ?><br>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'expireTime'); ?>
    <?php echo $form->textField($model, 'expireTime', array('class' => 'form-control','readonly'=>  HSetting::IsFixed('expireTime', 'cache'))); ?><br>
</div>

<hr>
<?php echo CHtml::submitButton(Yii::t('AdminModule.base', 'Save & Flush Caches'), array('class' => 'btn btn-primary')); ?>

<!-- show flash message after saving -->
<?php $this->widget('application.widgets.DataSavedWidget'); ?>

<?php $this->endWidget(); ?>








