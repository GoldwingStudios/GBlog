/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

<?php

include 'backend/sql_connect.php';
include 'backend/get_page.php';
include 'backend/crawler.php';
include 'modules/blog_core/get_blog_posts.php';
include 'modules/blog_core/show_spec_post.php';
include 'modules/blog_core/Get_Tag_Posts.php';
include 'modules/Comments/backend/Get_Comments.php';
include 'modules/Comments/backend/Save_Comment_Request.php';
include 'modules/rss/rss_creator.php';

