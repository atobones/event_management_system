<?php
require_once 'classes/User.php';
require_once 'csrf.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'])) {
        die('CSRF token validation failed');
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $userData = $user->login($username, $password);

    if ($userData) {
        $_SESSION['user'] = $userData;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Login</h1>
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green;">Registration successful! You can now log in.</p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
