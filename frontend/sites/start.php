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
?>
<div class="main__image">
    <a href="http://www.goldwingstudios.de" target="_blank">
        <img src="assets/images/gws.png"/>
    </a>
</div>
<div class="main">
    <div class="main__nav">
        <ul class="nav__list">
            <a href="index.php">
                <li class="nav__item">
                    <div class="helper"></div>
                    Main
                </li>
            </a>
            <a href="index.php?search">
                <li class="nav__item">
                    <div class="helper"></div>
                    Search
                </li>
            </a>
            <a href="?rss">
                <li class="nav__item">
                    <div class="helper"></div>
                    Rss-Feed
                </li>
            </a>
            <a href="https://github.com/GoldwingStudios/GBlog" target="_blank">
                <li class="nav__item">
                    <div class="helper"></div>
                    GitHub
                </li>
            </a>
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
            $Visible_Post->GetSpecificPost($post);
            ?>
        </div>
        <?php
    } else if (isset($tag)) {
        ?>
        <div class="blog__content">
            <?php
            $Visible_Tag_Posts = new Get_Tag_Posts();
            $Visible_Tag_Posts->Show_Tagged_Posts($tag);
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
            $Visible_Tag_Posts->Show_Related_Tags($tag);
            ?>
        </ul>
        <?php
        $Social_Media = new Show_Social_Media();
        $Social_Media->Show_Social_Media_Links();
        ?>
    </div>
</div>