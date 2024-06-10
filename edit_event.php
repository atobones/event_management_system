<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Event.php';
require_once 'csrf.php';

$event = new Event();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }

    $id = $_POST['id'];
    $event_name = $_POST['event_name'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];

    if ($event->update($id, $event_name, $description, $event_date, $location)) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Failed to update event!";
    }
} else {
    $id = $_GET['id'];
    $event_data = $event->read($id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            margin: 20px auto;
        }
        .form-container h1 {
            color: #333;
        }
        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="datetime-local"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-container button {
            background: #ff7e5f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 100%;
        }
        .form-container button:hover {
            background: #feb47b;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Edit Event</h1>
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <form method="POST" action="edit_event.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($event_data['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="event_name" placeholder="Event Name" value="<?php echo htmlspecialchars($event_data['event_name'], ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <textarea name="description" placeholder="Description" required><?php echo htmlspecialchars($event_data['description'], ENT_QUOTES, 'UTF-8'); ?></textarea><br>
            <input type="datetime-local" name="event_date" value="<?php echo htmlspecialchars($event_data['event_date'], ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <input type="text" name="location" placeholder="Location" value="<?php echo htmlspecialchars($event_data['location'], ENT_QUOTES, 'UTF-8'); ?>" required><br>
            <button type="submit">Update Event</button>
        </form>
        <a href="index.php">Back to events</a>
    </div>
</body>
</html>



