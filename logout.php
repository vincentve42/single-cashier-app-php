<?php

require __DIR__ . "/./autoloader/load.php";

if(!checkAuth())
{
    header('Location: login.php');
}

session_unset();
header('Location: login.php');
?>