<!-- MODULE ROW // -->
<tr>
    <td align="center" valign="top">
        <!-- CENTERING TABLE // -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <tr>
                    <td align="center" valign="top">
                        <!-- FLEXIBLE CONTAINER // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer">
                            <tbody>
                                <tr>
                                    <td valign="top" width="600" class="flexibleContainerCell">

                                        <!-- CONTENT TABLE // -->
                                        <table align="Left" border="0" cellpadding="0" cellspacing="0" width="60"
                                               class="flexibleContainer">
                                            <tbody>
                                                <tr>
                                                    <td align="Left" valign="top" class="imageContent">
                                                        <a href="<?php echo Yii::app()->createUrl('profile/show', array('guid' => $creator->guid)); ?>">
                                                            <img src="<?php echo $sourceObject->getProfileImage()->getUrl(); ?>"
                                                                 width="50" class="flexibleImage">
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- // CONTENT TABLE -->


                                        <!-- CONTENT TABLE // -->
                                        <table align="Right" border="0" cellpadding="0" cellspacing="0" width="480"
                                               class="flexibleContainer">
                                            <tbody><tr>
                                                    <td valign="top" class="textContent">
                                                        <?php echo Yii::t('SpaceModule.notifications', '{userName} declined your membership request in {spaceName}', array('{userName}' => '<strong>' . $creator->displayName . '</strong>', '{spaceName}' => '<strong>' . $targetObject->name . '</strong>')); ?> 
                                                        <a href="<?php echo $notification->getUrl(); ?>" target="_blank"><?php echo Yii::t('SpaceModule.notifications', 'Go to space'); ?></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- // CONTENT TABLE -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- // FLEXIBLE CONTAINER -->
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- // CENTERING TABLE -->
    </td>
</tr>















