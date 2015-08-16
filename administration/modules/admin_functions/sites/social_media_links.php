<?php
/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$Social_Media_Links = new Social_Media_Links();
if (isset($Social_Media_Links->links) && $Social_Media_Links->links != "" && $_SESSION["Logged_In"]) {
    $return = $Social_Media_Links->Set_SML();
}
$Return_SML = $Social_Media_Links->Get_SML();
?>
<script src="modules/js/SML_AddNewLink.js"></script>
<div class="start">
    <div class="navigation">
        <?php
        include ("modules/UI/navigation/navigation.php");
        ?>
    </div>
    <div class="start_content">
        <?php
        if ($_SESSION["Logged_In"]) {
            ?>
            <div class="content_layout">
                <div class="page_title">
                    <span class="page_description">Hier k&ouml;nnen Sie SocialMedia-Links zu Ihrem Blog hinzufügen und entfernen!</span>
                </div>
                <div class="page_content">
                    <div class="form_container">
                        <?php
                        if (isset($return)) {
                            if ($return) {
                                ?>
                                <div>
                                    <b>Social Media Links wurden erfolgreich gesetzt!</b>
                                </div>  
                                <?php
                            } else {
                                ?>
                                <div>
                                    <b>Es ist ein Fehler aufgetreten!
                                        <br>Bitte versuchen Sie es erneut!</b>
                                </div>
                                <?php
                            }
                        }
                        ?>

                        <form id="social_media_form" method="post" action="index.php?sm=some">
                            <?php
                            if (!empty($Return_SML)) {
                                $counter = 1;
                                foreach ($Return_SML as $sml_link) {
                                    ?>
                                    <div class="social_media">
                                        <?php
                                        if (isset($sml_link["sml_link"])) {
                                            ?>
                                            <div id="SML_ID_<?php echo $counter; ?>" class = "social_media">
                                                <input id="<?php echo $counter; ?>_type" class="social_media_input_type" name="<?php echo $sml_link["sml_type"] ?>_type" type="text" placeholder="Input a type" value="<?php echo $sml_link["sml_type"] ?>"/>
                                                <input id="<?php echo $counter; ?>_link" class="social_media_input_link" name="<?php echo $sml_link["sml_type"] ?>_link" type="text" placeholder="Input a link" value="<?php echo $sml_link["sml_link_text"] ?>" />
                                                <img id="<?php echo $counter; ?>" class="SML_delete_Link" src="../assets/images/delete.svg" />
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <input class="social_media_input" type="text" name="youtube_link" placeholder="Input a <?php ucfirst($sml_link["sml_type"]) ?> link" />
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                $counter++;
                            }
                            ?>
                            <div class="SML_control_container">
                                <input class="SML_AddSocialMediaLink" id="AddSocialMediaLink" type="button" value="Add Social Media Link" />
                                <input class="SML_Submit" name="submitted" type="submit" value="Save" />
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            } else if (($_SESSION["Logged_In"] && isset($_GET["logout"])) || (!$_SESSION["Logged_In"] && isset($_GET["logout"]))) {
                $Logout_Module = new Logout();
                $Logout_Module->Run();
            } else {
                echo "<script>window.location.replace('./index.php');</script>";
            }
            ?>
        </div>
    </div>
</div>