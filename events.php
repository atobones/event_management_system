<?php
require_once 'classes/User.php';
require_once 'classes/Session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $session = new Session();
    $session->start();

    if ($loggedInUser = $user->login($username, $password)) {
        $session->set('user', $loggedInUser);
        echo "Login successful!";
    } else {
        echo "Login failed!";
    }
}
?>

<form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
