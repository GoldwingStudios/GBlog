<?php

if (file_exists("../../../../installer.php")) {
    unlink("../../../../installer.php");
}

header('Location: ../../../index.php');
exit;
