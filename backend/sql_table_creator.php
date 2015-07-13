<?php

$sql = new sql_connect();
$blog_posts_query = "SHOW TABLES LIKE 'blog_posts';";
$blog_posts_result = $sql->return_row($blog_posts_query);

if (empty($blog_posts_result)) {
    $blog_posts_query = "CREATE TABLE `blog_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(75) NOT NULL,
  `post_text` text NOT NULL,
  `post_date` datetime NOT NULL,
  `post_visible` tinyint(1) NOT NULL DEFAULT '1',
  `post_tags` varchar(45) NOT NULL,
  PRIMARY KEY (`post_id`,`post_title`,`post_date`,`post_tags`),
  UNIQUE KEY `id_UNIQUE` (`post_id`),
  UNIQUE KEY `post_title_UNIQUE` (`post_title`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;";
    $blog_posts_result = $sql->execute($blog_posts_query);
}

$blog_comments_query = "SHOW TABLES LIKE 'blog_comments';";
$blog_comments_result = $sql->return_row($blog_comments_query);

if (empty($blog_comments_result)) {
    $blog_comments_query = "CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `comment_name` varchar(75) NOT NULL,
  `comment_mail` varchar(75) NOT NULL,
  `comment_text` longtext NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_valid` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
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

$blog_users_query = "SHOW TABLES LIKE 'blog_users';";
$blog_users_result = $sql->return_row($blog_users_query);

if (empty($blog_users_result)) {
    $blog_users_query = "CREATE TABLE `blog_users` (
  `id` int(11) NOT NULL,
  `usr_type` varchar(45) NOT NULL,
  `usr_username` varchar(45) NOT NULL,
  `usr_password` varchar(45) NOT NULL,
  PRIMARY KEY (`id`,`usr_type`,`usr_username`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `username_UNIQUE` (`usr_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
    $blog_users_result = $sql->execute($blog_users_query);
}


$xml_files = glob("post_data/posts/*.xml");
natsort($xml_files);
foreach ($xml_files as $xml_file) {
    $file = simplexml_load_file($xml_file);
    $post_title = (string) $file->title;
    $post_text = (string) $file->text;
    $post_tags = (string) $file->tags;
    $post_visible = (string) $file->visible;

    $blog_post = "SELECT * FROM blog_posts WHERE `post_title`='$post_title'";
    $blog_post_result = $sql->return_row($blog_post);
    if (empty($blog_post_result)) {
        $date = new DateTime((string) $file->date);
        $post_date = $date->format("Y-m-d H:i:s");

        $post_sql = "INSERT INTO blog_posts (`post_title`, `post_text`, `post_date`, `post_visible`, `post_tags`) VALUES ('$post_title', '$post_text', '$post_date', '$post_visible', '$post_tags')";
        $set_post_result = $sql->execute($post_sql);

        $post_comments = (string) $file->comments;
        $comments = explode("</comment>", $post_comments);
    }
}
?>