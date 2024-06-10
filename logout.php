<?php
require_once 'classes/Session.php';
$session = new Session();
$session->start();
$session->destroy();
header('Location: login.php');
?>
