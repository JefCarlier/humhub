<div class="modal-dialog">
    <div class="modal-content">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'space-apply-form',
            'enableAjaxValidation' => true,
        ));
        ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?php echo Yii::t('SpaceModule.base', "Request space membership"); ?></h4>
        </div>
        <div class="modal-body">

            <?php echo Yii::t('SpaceModule.base', 'Please shortly introduce yourself, to become an approved member of this space.'); ?>

            <br/>
            <br/>



            <?php //echo $form->labelEx($model, 'message'); ?>
            <?php echo $form->textArea($model, 'message', array('rows' => '8', 'class' => 'form-control', 'id' => 'request-message')); ?>
            <?php echo $form->error($model, 'message'); ?>


        </div>
        <div class="modal-footer">

            <?php
            echo CHtml::ajaxButton(Yii::t('SpaceModule.base', 'Send'), array('//space/space/requestMembershipForm', 'sguid' => $space->guid), array(
                'type' => 'POST',
                'beforeSend' => 'function(){ jQuery("#send-loader").removeClass("hidden"); }',
                'success' => 'function(html){ $("#globalModal").html(html); }',
            ), array('class' => 'btn btn-primary'));
            ?>


            <button type="button" class="btn btn-primary"
                    data-dismiss="modal"><?php echo Yii::t('base', 'Close'); ?></button>

            <div class="col-md-1 modal-loader">
                <div id="send-loader" class="loader loader-small hidden"></div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>

</div>


<script type="text/javascript">

    // set focus to input field
    $('#request-message').focus()

    /*
     * Modal handling by close event
     */
    $('#globalModal').on('hidden.bs.modal', function (e) {

        // Reload whole page (to see changes on it)
        //window.location.reload();

        // just close modal and reset modal content to default (shows the loader)
        $('#globalModal').html('<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><div class="loader"></div></div></div></div>');
    })
</script>
