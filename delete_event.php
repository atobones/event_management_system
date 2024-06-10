<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    require_once 'classes/Event.php';
    $event = new Event();
    if ($event->delete($_GET['id'])) {
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to delete event!";
    }
}
?>