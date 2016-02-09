<?php

if (file_exists("installer.php")) {
    ?>
    <div class="alert alert-warning">
        <span>
            The Installer-File still exists!<br/>Please delete it soon!
        </span>
        <a class="btn btn-info delete-installer" href="modules/admin_functions/functions/delete_installer.php">
            Delete!
        </a>
    </div>
    <?php
}