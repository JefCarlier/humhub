<h1><?php echo Yii::t('AdminModule.base', 'Accept user: {displayName} ', array('{displayName}' => $model->displayName)); ?></h1>
<br>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'approve-acceptuser-form',
    'enableAjaxValidation' => false,
        ));
?>

    <?php //echo $form->errorSummary($approveFormModel);  ?>

<div class="form-group">
    <?php echo $form->labelEx($approveFormModel, 'subject'); ?>
<?php echo $form->textField($approveFormModel, 'subject', array('class' => 'form-control')); ?>
<?php echo $form->error($approveFormModel, 'subject'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($approveFormModel, 'message'); ?>
<?php echo $form->textArea($approveFormModel, 'message', array('rows' => 6, 'cols' => 50, 'class' => 'form-control wysihtml5')); ?>
<?php echo $form->error($approveFormModel, 'message'); ?>
</div>

<script>
    $('.wysihtml5').wysihtml5({
        "font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": false, //Button which allows you to edit the generated HTML. Default false
        "link": true, //Button to insert a link. Default true
        "image": false, //Button to insert an image. Default true,
        "color": false, //Button to change color of font
        "size": 'sm' //Button size like sm, xs etc.
    });
</script>

<hr>
<?php echo CHtml::submitButton(Yii::t('AdminModule.base', 'Send & save'), array('class' => 'btn btn-primary')); ?>
 <a href="<?php echo $this->createUrl('//admin/approval/'); ?>"
   class="btn btn-primary"><?php echo Yii::t('AdminModule.base', 'Cancel'); ?></a>

<?php $this->endWidget(); ?>



