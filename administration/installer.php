<?php
error_reporting(E_ALL);
session_start();

class Installer {

    function __construct($host, $user, $pass, $db) {
        $this->mysqli = new mysqli($host, $user, $pass, $db);

        session_destroy();
        $cookieParams = session_get_cookie_params();
        setcookie(session_name(), '', 0, $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);
        $_SESSION = array();
    }

    function __destruct() {
        $this->mysqli->close();
    }

    function create_blog_posts() {
        if ($this->notexisting('blog_posts')) {
            $q = "CREATE TABLE `blog_posts` (
	  `post_id` int(11) NOT NULL AUTO_INCREMENT,
	  `post_title` varchar(75) NOT NULL,
	  `post_text` text NOT NULL,
	  `post_date` datetime NOT NULL,
	  `post_visible` tinyint(1) NOT NULL DEFAULT '1',
	  `post_tags` varchar(45) NOT NULL,
          `post_image_path` varchar(150) NOT NULL,
	  PRIMARY KEY (`post_id`,`post_title`,`post_date`,`post_tags`),
	  UNIQUE KEY `id_UNIQUE` (`post_id`),
	  UNIQUE KEY `post_title_UNIQUE` (`post_title`)
	) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;";

            if ($r = $this->mysqli->query($q)) {
                return true;
            } else {
                return (string) $this->mysqli->error;
            }
        } else {
            return (string) "blog_posts existing";
        }
    }

    function create_blog_comments() {
        if ($this->notexisting('blog_comments')) {

            $q = "CREATE TABLE `blog_comments` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `post_id` int(11) NOT NULL,
	  `comment_name` varchar(75) NOT NULL,
	  `comment_mail` varchar(75) NOT NULL,
	  `comment_text` longtext NOT NULL,
	  `comment_date` datetime NOT NULL,
	  `comment_valid` int(1) NOT NULL DEFAULT '0',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";

            if ($r = $this->mysqli->query($q)) {
                return true;
            } else {
                return (string) $this->mysqli->error;
            }
        } else {
            return (string) "blog_comments existing";
        }
    }

    function create_blog_sites() {
        if ($this->notexisting('sites')) {
            $q = "CREATE TABLE `sites` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `template` varchar(45) NOT NULL,
	  `visible` tinyint(1) NOT NULL,
	  `name` varchar(45) NOT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `id_UNIQUE` (`id`),
	  UNIQUE KEY `templates_UNIQUE` (`template`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            if ($r = $this->mysqli->query($q)) {
                $q_site = "INSERT INTO sites (`template`, `visible`, `name`) VALUES ('start', '1', 'Start');";
                if ($r_site = $this->mysqli->query($q_site)) {
                    return true;
                } else {
                    return (string) $this->mysqli->error;
                }
            } else {
                return (string) $this->mysqli->error;
            }
        } else {
            return (string) "sites existing";
        }
    }

    function create_blog_users() {
        if ($this->notexisting('blog_users')) {
            $q = "CREATE TABLE `blog_users` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `usr_type` varchar(45) NOT NULL,
	  `usr_username` varchar(45) NOT NULL,
	  `usr_password` varchar(130) NOT NULL,
	  PRIMARY KEY (`id`,`usr_type`,`usr_username`),
	  UNIQUE KEY `id_UNIQUE` (`id`),
	  UNIQUE KEY `username_UNIQUE` (`usr_username`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            if ($r = $this->mysqli->query($q)) {
                return true;
            } else {
                return (string) $this->mysqli->error;
            }
        } else {
            return (string) "blog_users existing";
        }
    }

    function notexisting($table) {
        $q = "SHOW TABLES LIKE '$table'";
        if ($r = $this->mysqli->query($q)) {
            if ($r->num_rows == null) {
                return true;
            }
        }
        return false;
    }

    // CREATE ADMIN ACCOUNT
    function create_account($username) {
        $q = "INSERT INTO blog_users (`usr_type`, `usr_username`, `usr_password`) VALUES ('Administrator', '$username', 'a274c12d6b7eb45d02307ec7a706278d82e03d989678c21d95dc57ab54dd46b324991c0452d7cd4453a1c744e6f5b3408e7fd5a537290c75b65c8802d3df3a14');";
        if ($r = $this->mysqli->query($q)) {
            return true;
        } else {
            return (string) $this->mysqli->error;
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>GBlog Installer</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="page-header">
                        <h1>GBlog <small>Installer</small></h1>
                    </div>
                    <div class="alert alert-warning">
                        Make sure you have created the database first!
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Database Connection</div>
                        <div class="panel-body">


                            <?php if (!isset($_POST["setdb"])) { ?>
                                <form action="installer.php" method="post">
                                    <p>Database</p>
                                    <div class="form-group">
                                        <input type="text" name="host" class="form-control" placeholder="Mysql Host (127.0.0.1)" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="user" class="form-control" placeholder="Mysql Username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="pass" class="form-control" placeholder="Mysql Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="db" class="form-control" placeholder="Mysql Database" required>
                                    </div>
                                    <p>Admin account</p>
                                    <div class="form-group">
                                        <input type="text" name="admin" class="form-control" placeholder="Username" required>
                                    </div>
                                    <button type="submit" name="setdb" class="btn btn-success">Create</button>
                                </form>
                                <?php
                            } else {
                                $installer = new Installer($_POST["host"], $_POST["user"], $_POST["pass"], $_POST["db"]);

                                $r = $installer->create_blog_posts();
                                if ($r === true) {
                                    echo "<div class='alert alert-success'>table blog_posts successfully created.</div>";
                                } else {
                                    echo '<div class="alert alert-danger">', $r, '</div>';
                                }
                                $r = null;

                                $r = $installer->create_blog_comments();
                                if ($r === true) {
                                    echo "<div class='alert alert-success'>table blog_comments successfully created.</div>";
                                } else {
                                    echo '<div class="alert alert-danger">', $r, '</div>';
                                }
                                $r = null;

                                $r = $installer->create_blog_sites();
                                if ($r === true) {
                                    echo "<div class='alert alert-success'>table sites successfully created.</div>";
                                } else {
                                    echo '<div class="alert alert-danger">', $r, '</div>';
                                }
                                $r = null;

                                $r = $installer->create_blog_users();
                                if ($r === true) {
                                    echo "<div class='alert alert-success'>table blog_users successfully created.</div>";
                                } else {
                                    echo '<div class="alert alert-danger">', $r, '</div>';
                                }
                                $r = null;

                                $r = $installer->create_account($_POST["admin"]);
                                if ($r === true) {
                                    echo "<div class='alert alert-success'>admin account successfully created.<br />
									<strong>Login password is <em>#pass_1234</em></strong>
                                                                        </div>";
                                } else {
                                    echo '<div class="alert alert-danger">', $r, '</div>';
                                }


                                /*
                                  define("DB_HOST","");
                                  define("DB_USER","");
                                  define("DB_PASSWORD","");
                                  define("DB_DATABASE","");
                                 */

                                $connector = fopen("./database_config.php", "w");
                                $dbinfo = '<?php
';
                                $dbinfo .= 'define("DB_HOST","' . $_POST["host"] . '");
';
                                $dbinfo .= 'define("DB_USER","' . $_POST["user"] . '");
';
                                $dbinfo .= 'define("DB_PASSWORD","' . $_POST["pass"] . '");
';
                                $dbinfo .= 'define("DB_DATABASE","' . $_POST["db"] . '");
';
                                $dbinfo .= '?>';
                                if (fwrite($connector, $dbinfo)) {
                                    echo "<div class='alert alert-success'>Connector created.</div>"
                                    . "<a class='btn btn-success' href='./index.php'>Login</a>";
                                } else {
                                    echo "<div class='alert alert-danger'>Failed to create the connector.</div>";
                                }
                                fclose($connector);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>