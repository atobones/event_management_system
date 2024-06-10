<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .welcome-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
            margin: 20px auto;
            position: relative;
        }
        .welcome-container h1 {
            color: #333;
        }
        .welcome-container p {
            color: #555;
        }
        .welcome-container a {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 20px;
            color: white;
            background: #ff7e5f;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .welcome-container a:hover {
            background: #feb47b;
        }
        .events-list {
            list-style-type: none;
            padding: 0;
        }
        .events-list li {
            background: #fff;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .events-list li .actions {
            display: flex;
        }
        .events-list li .actions a {
            margin-left: 10px;
            padding: 5px 10px;
            border-radius: 5px;
            background: #ff7e5f;
            color: white;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .events-list li .actions a:hover {
            background: #feb47b;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome, <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?>!</h1>
        <p>You are logged in as <?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>.</p>
        <a href="add_event.php">Add Event</a>
        <a href="logout.php">Logout</a>

        <h2>Your Events</h2>
        <?php
        require_once 'classes/Event.php';
        $event = new Event();
        $events = $event->getUserEvents($user['id']);
        if ($events) {
            echo '<ul class="events-list">';
            foreach ($events as $event) {
                echo '<li>' . htmlspecialchars($event['event_name'], ENT_QUOTES, 'UTF-8') . ' - ' . htmlspecialchars($event['event_date'], ENT_QUOTES, 'UTF-8');
                echo '<div class="actions">';
                echo '<a href="edit_event.php?id=' . htmlspecialchars($event['id'], ENT_QUOTES, 'UTF-8') . '">Edit</a>';
                echo '<a href="delete_event.php?id=' . htmlspecialchars($event['id'], ENT_QUOTES, 'UTF-8') . '">Delete</a>';
                echo '</div></li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No events found.</p>';
        }
        ?>
    </div>
</body>
</html>



