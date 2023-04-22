<?php
// Define variables and initialize with empty values
$name = $email = $password = $confirm_password = $phone = "";
$name_err = $email_err = $password_err = $confirm_password_err = $phone_err = "";

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validate name
  if (empty(trim($_POST["name"]))) {
    $name_err = "Please enter your name.";
  } else {
    $name = trim($_POST["name"]);
  }

  // Validate email
  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter your email address.";
  } else {
    // Check if email address is already taken
    // You can replace this with your own email validation logic
    if (false) {
      $email_err = "This email address is already taken.";
    } else {
      $email = trim($_POST["email"]);
    }
  }

  // Validate password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter a password.";
  } elseif (strlen(trim($_POST["password"])) < 6) {
    $password_err = "Password must have at least 6 characters.";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate confirm password
  if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Please confirm password.";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($password_err) && ($password != $confirm_password)) {
      $confirm_password_err = "Password did not match.";
    }
  }

  // Validate phone number
  if (empty(trim($_POST["phone"]))) {
    $phone_err = "Please enter your phone number.";
  } else {
    $phone = trim($_POST["phone"]);
  }

  // Check input errors before inserting in database
  if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err)) {
    // You can replace this with your own database insertion logic
    // Open a connection to the database
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "myDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare an insert statement
    $sql = "INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("ssss", $param_name, $param_email, $param_password, $param_phone);

      // Set parameters
      $param_name = $name;
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
      $param_phone = $phone;

      // Attempt to execute the prepared statement
      if ($stmt->execute()) {
        // Redirect to login page
        header("location: login.php");
        exit();
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      $stmt->
