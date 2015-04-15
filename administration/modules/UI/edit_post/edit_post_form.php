/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php
if (isset($edit_return) && $return_post == "") {
    $Edit_Post;
    ?>
    <form method="post" action="index.php?sm=edit&amp;m=edm&amp;id=<?php echo $post_id; ?>">
        <div class="post_title">
            <span class="post_title">Post-Titel:</span><br/>
            <div class="date_legend">
            </div>
            <div class="middle_object">
                <?php
                if ($x = isset($edit_return["post_title"])) {
                    ?>
                    <input class="input_field_title_red" type="text" name="post_title" title="<?php echo $edit_return["post_title"]["message"]; ?>" value="<?php echo $edit_return["post_title"]["value"] ?>" />
                    <?php
                } else {
                    ?>
                    <input class="input_field_title" type="text" name="post_title" value="<?php echo $Edit_Post->post_title ?>" />
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="post_date">
            <span class="post_date">Post-Datum:</span><br/>
            <div class="date_legend">
                <div class="date_legend_inline">
                    <span>Datum</span>
                </div>
                <div class="date_legend_inline">
                    <span>Zeit</span>
                </div>
            </div>
            <div class="middle_object_small">
                <?php
                if ($x = isset($edit_return["post_date_calendar"])) {
                    ?>
                    <input class="input_field_date_red" type="text" name="post_date_calendar" title="<?php echo $edit_return["post_date_calendar"]["message"]; ?>" value="<?php echo $edit_return["post_date_calendar"]["value"] ?>" />
                    <?php
                } else {
                    ?>
                    <input class="input_field_date" type="text" name="post_date_calendar" value="<?php echo $Edit_Post->post_date_calendar ?>" />
                    <?php
                }
                ?>
                <?php
                if ($x = isset($edit_return["post_date_time"])) {
                    ?>
                    <input class="input_field_date_red" type="text" name="post_date_time" title="<?php echo $edit_return["post_date_time"]["message"]; ?>" value="<?php echo $edit_return["post_date_time"]["value"] ?>" />
                    <?php
                } else {
                    ?>
                    <input class="input_field_date" type="text" name="post_date_time" value="<?php echo $Edit_Post->post_date_time ?>" />
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="post_text">
            <div class="input_container">
                <span class="post_textarea">Post-Text:</span><br/>
                <div class="middle_object_large">
                    <?php
                    if ($x = isset($edit_return["post_text"])) {
                        ?>
                        <textarea class="input_field_text_red" type="text" title="<?php echo $edit_return["post_text"]["message"]; ?>" name="post_text" ><?php echo $edit_return["post_text"]["value"] ?></textarea>
                        <?php
                    } else {
                        ?>
                        <textarea class="input_field_text" type="text" name="post_text" ><?php echo $Edit_Post->post_text ?></textarea>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div><br/>
        <div class="post_tags">
            <span class="post_text">Post-Tags:</span><br/>
            <div class="middle_object">
                <?php
                if ($x = isset($edit_return["post_tags"])) {
                    ?>
                    <input class="input_field_tags_red" type="text" name="post_tags" title="<?php echo $edit_return["post_tags"]["message"]; ?>" value="<?php echo $edit_return["post_tags"]["value"]; ?>" />
                    <?php
                } else {
                    ?>
                    <input class="input_field_tags" type="text" name="post_tags" value="<?php echo $Edit_Post->post_tags ?>" />
                    <?php
                }
                ?>

                <input style="display: none;" type="text" name="post_visible" value="<?php echo $Edit_Post->post_visible ?>" />
            </div>
        </div>
        <div class="submit_container">
            <div class="edit_submit">
                <input class="edit_submit" type="submit" value="Speichern"  />
                <div class="backlink" onclick="window.location.href = 'index.php?sm=edit';"><u><b>Zur&uuml;ck zum EDIT-Men&uuml;</b></u></div>
            </div>
        </div>
    </form>
    <?php
} else if ($edit_return == "" && isset($return_post)) {
    $post_date = explode(", ", $return_post->date);
    ?>
    <form method="post" action="index.php?sm=edit&amp;m=edm&amp;id=<?php echo $post_id; ?>">
        <div class="post_title">
            <span class="post_title">Post-Titel:</span><br/>
            <div class="date_legend">
            </div>
            <div class="middle_object">
                <input class="input_field_title" type="text" name="post_title" value="<?php echo $return_post->title ?>" />
            </div>
        </div>
        <div class="post_date">
            <span class="post_date">Post-Datum:</span><br/>
            <div class="date_legend">
                <div class="date_legend_inline">
                    <span>Datum</span>
                </div>
                <div class="date_legend_inline">
                    <span>Zeit</span>
                </div>
            </div>
            <div class="middle_object_small">
                <input class="input_field_date" type="text" name="post_date_calendar" value="<?php echo $post_date[0] ?>" />
                <input class="input_field_date" type="text" name="post_date_time" value="<?php echo $post_date[1] ?>" />
            </div>
        </div>
        <div class="post_text">
            <div class="input_container">
                <span class="post_textarea">Post-Text:</span><br/>
                <div class="middle_object_large">
                    <textarea class="input_field_text" type="text" name="post_text" ><?php echo $return_post->text ?></textarea>
                </div>
            </div>
        </div><br/>
        <div class="post_tags">
            <span class="post_text">Post-Tags:</span><br/>
            <div class="middle_object">
                <input class="input_field_tags" type="text" name="post_tags" value="<?php echo $return_post->tags ?>" />
                <input style="display: none;" type="text" name="post_visible" value="<?php echo $return_post->visible ?>" />
            </div>
        </div>
        <div class="submit_container">
            <div class="edit_submit">
                <input class="edit_submit" type="submit" value="Speichern"  />
                <div class="backlink" onclick="window.location.href = 'index.php?sm=edit';"><u><b>Zur&uuml;ck zum EDIT-Men&uuml;</b></u></div>
            </div>
        </div>
    </form>
    <?php
}
?>