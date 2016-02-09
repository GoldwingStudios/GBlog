<?php
/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
if ((USER_LOGGED_IN && isset($_GET["logout"])) || (!USER_LOGGED_IN && isset($_GET["logout"]))) {
	$Logout_Module = new Logout();
	$Logout_Module->Run();
}

$p = new Page();
$p->_Page();
include 'frontend/templates/header.php';
echo '<div class="container">';
?>

<div class = "image_container">
	<a href="http://www.goldwingstudios.de" target="_blank">
		<img class="gws_banner" src="assets/images/fgws.png"/>
	</a>
</div>

<?php
include(PAGE_CONTENT);
echo '</div>';
include 'frontend/templates/footer.php';
?>