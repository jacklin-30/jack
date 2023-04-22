<?php

// start the session
session_start();

// check if the user is already logged in
if (isset($_SESSION['user_id'])) {
  // if yes, redirect to the home page
  header('Location: index1.html');
  exit();
}

// check if the form is submitted
if (isset($_POST['submit'])) {
  // get the username and password from the form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // check if the username and password are correct
  // (you will need to replace the database connection code and the SQL query with your own)
  $conn = mysqli_connect('localhost', 'username', 'password', 'database');
  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    // if yes, set the session variable and redirect to the home page
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['id'];
    header('Location: index.php');
    exit();
  } else {
    // if no, show an error message
    $error = "Invalid username or password.";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
</head>
<body>

  <h1>Login</h1>

  <?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>

  <form method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <input type="submit" name="submit" value="Login">
  </form>

</body>
</html>
