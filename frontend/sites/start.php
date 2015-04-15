<?php
$post = filter_input(INPUT_GET, "post");
$tag = filter_input(INPUT_GET, "tag");
$search = filter_input(INPUT_GET, "search");
$mode = filter_input(INPUT_GET, "gH3uXC");
$Visible_Tag_Posts = new Get_Tag_Posts();
if (!isset($mode)) {
    ?>
    <div class="image_container">
        <a href="http://www.goldwingstudios.de" target="_blank">
            <img class="gws_banner" src="assets/images/fgws.png"/>
        </a>
    </div>
    <div class="start">
        <div class="navigation">
            <a href="index.php">
                <div class="nav_item">
                    <span class="nav_text"><!--<img class="rss_img_nav" src="assets/images/home.png"/>-->Start</span>
                </div>
            </a>
            &nbsp;
            <a href="index.php?search">
                <div class="nav_item">
                    <span class="nav_text"><!--<img class="rss_img_nav" src="assets/images/search.png"/>-->Search</span>
                </div>
            </a>
            &nbsp;
            <a href="?rss" target="_blank">
                <div class="nav_item">

                    <span class="nav_text"><img class="rss_img_nav" src="assets/images/rss.png"/>Feed</span>
                </div>
            </a>
        </div>
        <?php
        if (!isset($post) && !isset($tag) && !isset($search)) {
            ?>
            <div class="blog_area">

                <div class="blog_posts">
                    <?php
                    $posts = new Blog_Posts();
                    $posts->get_blog_posts();
                    ?>
                </div>
                <div class="blog_functions">

                    <?php
                    $Visible_Tag_Posts->output_most_related_tags();
                    ?>
                </div>
            </div>
            <?php
        } else if (isset($post)) {
            ?>
            <div class="blog_area">
                <?php
                $Visible_Post = new Show_Post();
                $Visible_Post->get_spec_post($post);
                include "modules/Comments/frontend/Comment_Section.php";
                ?>
                <div class="blog_functions">
                    <?php
                    $Visible_Tag_Posts->output_most_related_tags();
                    ?>
                </div>
            </div>
            <?php
        } else if (isset($tag)) {
            ?>
            <div class="blog_area">
                <div class="blog_posts">
                    <?php
                    $Visible_Tag_Posts = new Get_Tag_Posts();
                    $Visible_Tag_Posts->show_posts_for_tag($tag);
                    ?>
                </div>
                <div class="blog_functions">
                    <?php
                    $Visible_Tag_Posts->output_most_related_tags();
                    ?>
                </div>
            </div>
            <?php
        } else if (isset($search)) {
            ?>
            <script src="modules/js/get_posts_by_search.js"></script>
            <div class="blog_area">
                <div class="blog_posts">
                    <div class="search_bar"><span>Full-Text Search:</span>
                        <input id="search_bar" name="search_bar" placeholder="Example: GChat Goldwing" style="width: 250px" />
                    </div>
                </div>
                <div class="blog_functions">
                    <?php
                    $Visible_Tag_Posts->output_most_related_tags();
                    ?>
                </div>
            </div>       
            <?php
        }
    }
    ?>
</div>