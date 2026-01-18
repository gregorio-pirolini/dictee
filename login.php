<?php
session_start();  // Add this at the top of your script
require("php/db_connect.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$submitted_username = '';

if (!empty($_POST)) {
    $query = "
        SELECT
            id,
            username,
            password,
            salt,
            email
        FROM users
        WHERE username = :username
    ";

    $query_params = array(
        ':username' => $_POST['username']
    );

    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    } catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());
    }

    $login_ok = false;

    // Fetch the data as an object
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    if ($row) {
        // Using object notation
        $check_password = hash('sha256', $_POST['password'] . $row->salt);

        for ($round = 0; $round < 65536; $round++) {
            $check_password = hash('sha256', $check_password . $row->salt);
        }
        
        // // Debugging output: Display the passwords for comparison
        

        if ($check_password === $row->password) {
            $login_ok = true;
        }
    } else {
        // If no row is returned, indicate that the login failed
        echo "Login Failed: Username not found.<br/>";
    }
    
    // If login is successful
    if ($login_ok) {
        // Unset sensitive values
        unset($row->salt);
        unset($row->password);

        // Store user data in session
        $_SESSION['user'] = $row;

        // Redirect to private page
        // echo "Login successful! Redirecting...";
        header("Location: index.php");
  exit;
    } else {
        // Display login failed message
        // echo "POST['password'] (hashed): " . $check_password;
        // echo "<br/>";
        // echo "Database 'password': " . $row->password;
        // echo "<br/>";
        print('<p class="logText">Login Failed...</p>');

        // Show username again
        $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
    }
}
?>


<link rel="icon" href="pix/dictee_yZp_icon.ico" type="image/x-icon" />
<link rel="stylesheet" href="css/main.css"/> 
<div class="log">
    <h1 style="padding:1em; margin:0;">
        <img src="pix/logo.jpg" id="logo">
    </h1>

    <center>
        <h1>Log in</h1>
        <form action="login.php" method="post">
            <p class="logText">User name:</p>
            <input type="text" name="username" value="<?php echo $submitted_username; ?>" />
            <br />
            <p class="logText">Password:</p>
            <input type="password" name="password" value="" />
            <br /><br />
            <input type="submit" value="Log in" class="clickMe" />
        </form>
        <br />
        <a href="logout.php" class="logMeOut">
            <button class="clickMe">Log out</button>
        </a>
    </center>
</div>
