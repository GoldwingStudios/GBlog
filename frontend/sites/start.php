<?php
/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
$post = filter_input(INPUT_GET, "post");
$tag = filter_input(INPUT_GET, "tag");
$search = filter_input(INPUT_GET, "search");
$mode = filter_input(INPUT_GET, "gH3uXC");
if (!isset($mode)) {
    ?>
    <div class="main__image">
        <a href="http://www.goldwingstudios.de" target="_blank">
            <img src="assets/images/gws.png"/>
        </a>
    </div>
    <div class="main">
        <div class="main__nav">
            <ul class="nav__list">
                <li class="nav__item">
                    <a href="index.php">Main</a>
                </li>
                <li class="nav__item">
                    <a href="index.php?search">Search</a>
                </li>
                <li class="nav__item">
                    <a href="?rss" target="_blank">Rss-Feed</a>
                </li>
                <li class="nav__item">
                    <a href="https://github.com/GoldwingStudios/GBlog" target="_blank">GitHub</a>
                </li>
                <!--                <li class="nav__item">
                                    <a href="#" target="_blank">Impressum</a>
                                </li>-->
            </ul>
        </div>

        <div class="blog__wrapper">
            <?php
            if (!isset($post) && !isset($tag) && !isset($search)) {
                ?>

                <div class="blog__content">
                    <?php
                    $posts = new Blog_Posts();
                    $posts->get_blog_posts();
                    ?>
                </div>

                <?php
            } else if (isset($post)) {
                ?>

                <div class="blog__content">
                    <?php
                    $Visible_Post = new Show_Post();
                    $Visible_Post->get_spec_post($post);
                    ?>
                </div>

                <?php
            } else if (isset($tag)) {
                ?>

                <div class="blog__content">
                    <?php
                    $Visible_Tag_Posts = new Get_Tag_Posts();
                    $Visible_Tag_Posts->show_posts_for_tag($tag);
                    ?>
                </div>

                <?php
            } else if (isset($search)) {
                ?>

                <script src="modules/js/get_posts_by_search.js"></script>

                <div class="blog__content">
                    <div class="blog__search">
                        <input id="search_bar" placeholder="Search..." class="blog__search__bar" />
                    </div>
                </div>

                <?php
            }
            ?>

            <div class="blog__sidebar">
                <h2>Popular Tags</h2>
                <ul class="blog__popular__tags">
                    <?php
                    $Visible_Tag_Posts = new Get_Tag_Posts();
                    $Visible_Tag_Posts->output_most_related_tags();
                    ?>
                </ul>
                <?php
                $Social_Media = new Show_Social_Media();
                ?>
                <h2>Social Media</h2>
                <div class="blog__social__media">
                    <?php
                    $Social_Media->Show_Social_Media_Links();
                    ?>
                    <!--                    <div class="social__media__badge">
                                                <img class="social__media__badge__icon" src="assets/images/youtube-256.png">
                                                <div class="social__media__badge__content">
                                                    <h1 class="social__media__badge__title">YouTube</h1>
                                                    <a href="http://twitch.com" class="social__media__badge__desc">http://youtube.com/goldwingstuff</a>
                                                </div>
                                            </div>-->
                </div>
                <!--
                <h2>Social Media</h2>
                $Social_Media->Show_Social_Media_Links();
                -->
            </div>
        </div>

        <?php
    }
    ?>
</div>