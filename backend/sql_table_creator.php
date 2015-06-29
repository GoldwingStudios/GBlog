<?php

$sql = new sql_connect();
$blog_posts_query = "SHOW TABLES LIKE 'blog_posts';";
$blog_posts_result = $sql->return_row($blog_posts_query);

if (empty($blog_posts_result)) {
    $blog_posts_query = "CREATE TABLE `blog_posts` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(75) NOT NULL,
  `post_text` text NOT NULL,
  `post_date` datetime NOT NULL,
  `post_visible` tinyint(1) NOT NULL DEFAULT '1',
  `post_tags` varchar(45) NOT NULL,
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `id_UNIQUE` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $blog_posts_result = $sql->execute($blog_posts_query);
}

$blog_comments_query = "SHOW TABLES LIKE 'blog_comments';";
$blog_comments_result = $sql->return_row($blog_comments_query);

if (empty($blog_comments_result)) {
    $blog_comments_query = "CREATE TABLE `blog_comments` (
  `post_id` int(11) NOT NULL,
  `comment_name` varchar(75) NOT NULL,
  `comment_mail` varchar(75) NOT NULL,
  `comment_text` longtext NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $blog_comments_result = $sql->execute($blog_comments_query);
}

$sites_query = "SHOW TABLES LIKE 'sites';";
$sites_result = $sql->return_row($sites_query);

if (empty($sites_result)) {
    $sites_query = "CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `template` varchar(45) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `templates_UNIQUE` (`template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $sites_result = $sql->execute($sites_query);
}
?>