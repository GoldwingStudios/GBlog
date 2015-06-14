<?php
/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$youtube_link = filter_input(INPUT_POST, "youtube_link");
$twitter_link = filter_input(INPUT_POST, "twitter_link");
$twitch_link = filter_input(INPUT_POST, "twitch_link");
$twitch_date = filter_input(INPUT_POST, "twitch_link_date");
$twitch_time = filter_input(INPUT_POST, "twitch_link_time");
if ((isset($youtube_link) || isset($twitter_link) || isset($twitch_link)) && $_SESSION["Logged_In"]) {
    $links = array($youtube_link, $twitter_link, $twitch_link);
    $dates = array($twitch_date, $twitch_time);
    $Social_Media_Links = new Social_Media_Links($links, $dates);
    $return = $Social_Media_Links->Set_SML();
}
?>
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
                    <span class="page_title"><?php echo ucwords(strtolower($_SESSION["current_page"])); ?></span><br/>
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

                        <form method="post" action="index.php?sm=some">
                            <div class="social_media">
                                <span>YouTube:</span>
                                <input class="social_media_input" name="youtube_link" placeholder="Input a YouTube-Channel link" />
                            </div>
                            <div class="social_media">
                                Twitter:
                                <input class="social_media_input" name="twitter_link" placeholder="Input a Twitter link" />
                            </div>
                            <div class="social_media_twitch">
                                Twitch:
                                <input class="social_media_input" name="twitch_link" placeholder="Input a Twitch link" />
                                <div>
                                    <br><span>Next streaming time:</span>
                                    <br><input class="twitch_time" name="twitch_link_date" placeholder="Input a stream date" />
                                    <br><br><input class="twitch_time" name="twitch_link_time" placeholder="Input a stream time" />
                                </div>
                            </div>
                            <div class="submit_container">
                                <input class="submit" type="submit" value="Speichern" />
                            </div>
                        </form>
                        <br><span style="cursor: pointer;" title="Because we hate Facebook!"><u>Why isn't there a Facebook link?</u></span>
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