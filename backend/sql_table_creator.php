<?php

$DB_Connect = new DB_Connect;
$Blog_Posts_Query = "SHOW TABLES LIKE 'blog_posts';";
$Blog_posts_Result = $DB_Connect->Return_PDO_Row($Blog_Posts_Query);

if (empty($Blog_posts_Result)) {
    $Blog_Posts_Query = "CREATE TABLE `blog_posts` (
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
    $Blog_posts_Result = $DB_Connect->Execute_PDO_Command($Blog_Posts_Query);
}

$Blog_Comments_Query = "SHOW TABLES LIKE 'blog_comments';";
$Blog_Comments_Result = $DB_Connect->Return_PDO_Row($Blog_Comments_Query);

if (empty($Blog_Comments_Result)) {
    $Blog_Comments_Query = "CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `comment_name` varchar(75) NOT NULL,
  `comment_mail` varchar(75) NOT NULL,
  `comment_text` longtext NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_valid` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
    $Blog_Comments_Result = $DB_Connect->Execute_PDO_Command($Blog_Comments_Query);
}

$Sites_Query = "SHOW TABLES LIKE 'sites';";
$Sites_Result = $DB_Connect->Execute_PDO_Command($Sites_Query);

if (empty($Sites_Result)) {
    $Sites_Query = "CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `template` varchar(45) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `templates_UNIQUE` (`template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $Sites_Result = $DB_Connect->Execute_PDO_Command($Sites_Query);
}

$Blog_Users_Query = "SHOW TABLES LIKE 'blog_users';";
$Blog_Users_Result = $DB_Connect->Execute_PDO_Command($Blog_Users_Query);

if (empty($Blog_Users_Result)) {
    $Blog_Users_Query = "CREATE TABLE `blog_users` (
  `id` int(11) NOT NULL,
  `usr_type` varchar(45) NOT NULL,
  `usr_username` varchar(45) NOT NULL,
  `usr_password` varchar(45) NOT NULL,
  PRIMARY KEY (`id`,`usr_type`,`usr_username`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `username_UNIQUE` (`usr_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
    $Blog_Users_Result = $DB_Connect->Execute_PDO_Command($Blog_Users_Query);
}


$xml_files = glob("post_data/posts/*.xml");
natsort($xml_files);
foreach ($xml_files as $xml_file) {
    $file = simplexml_load_file($xml_file);
    $post_title = (string) $file->title;
    $post_text = (string) $file->text;
    $post_tags = (string) $file->tags;
    $post_visible = (string) $file->visible;

    $Blog_Post = "SELECT * FROM blog_posts WHERE `post_title`='$post_title'";
    $Blog_Post_Result = $DB_Connect->Return_PDO_Row($Blog_Post);
    if (empty($Blog_Post_Result)) {
        $Date = new DateTime((string) $file->date);
        $Post_Date_Formatted = $Date->format("Y-m-d H:i:s");

        $Create_Post_Sql = "INSERT INTO blog_posts (`post_title`, `post_text`, `post_date`, `post_visible`, `post_tags`) VALUES ('$post_title', '$post_text', '$post_date', '$post_visible', '$post_tags')";
        $set_post_result = $DB_Connect->Execute_PDO_Command($Create_Post_Sql);

        $post_comments = (string) $file->comments;
        $comments = explode("</comment>", $post_comments);
    }
}
?>