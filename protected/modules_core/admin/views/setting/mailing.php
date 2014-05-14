<h1><?php echo Yii::t('AdminModule.base', 'Mailing - Settings'); ?></h1><br>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'mailing-settings-form',
    'enableAjaxValidation' => false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'systemEmailAddress'); ?>
    <?php echo $form->textField($model, 'systemEmailAddress', array('class' => 'form-control', 'readonly'=>  HSetting::IsFixed('systemEmailAddress', 'mailing'))); ?>
</div>


<div class="form-group">
    <?php echo $form->labelEx($model, 'systemEmailName'); ?>
    <?php echo $form->textField($model, 'systemEmailName', array('class' => 'form-control', 'readonly'=>  HSetting::IsFixed('systemEmailName', 'mailing'))); ?>
</div>


<div class="form-group">
    <?php echo $form->labelEx($model, 'transportType'); ?>
    <?php echo $form->dropDownList($model, 'transportType', $transportTypes, array('class' => 'form-control', 'readonly'=>  HSetting::IsFixed('transportType', 'mailing'))); ?>
</div>

<hr>
<h4> <?php echo Yii::t('AdminModule.base', 'SMTP Options'); ?> </h4>

<div class="form-group">
    <?php echo $form->labelEx($model, 'hostname'); ?>
    <?php echo $form->textField($model, 'hostname', array('class' => 'form-control', 'readonly'=>  HSetting::IsFixed('hostname', 'mailing'))); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'username'); ?>
    <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'readonly'=>  HSetting::IsFixed('username', 'mailing'))); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'password'); ?>
    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'readonly'=>  HSetting::IsFixed('password', 'mailing'))); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'port'); ?>
    <?php echo $form->textField($model, 'port', array('class' => 'form-control', 'readonly'=>  HSetting::IsFixed('port', 'mailing'))); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'encryption'); ?>
    <?php echo $form->dropDownList($model, 'encryption', $encryptionTypes, array('class' => 'form-control', 'readonly'=>  HSetting::IsFixed('encryption', 'mailing'))); ?>
</div>

<hr>
<?php echo CHtml::submitButton(Yii::t('AdminModule.base', 'Save'), array('class' => 'btn btn-primary')); ?>

<!-- show flash message after saving -->
<?php $this->widget('application.widgets.DataSavedWidget'); ?>

<?php $this->endWidget(); ?>





