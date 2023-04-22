<?php

// start the session
session_start();

// check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
  // if not, redirect to the login page
  header('Location: login.php');
  exit();
}

// display a welcome message with the user's name
$user_id = $_SESSION['user_id'];
$conn = mysqli_connect('localhost', 'username', 'password', 'database');
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$username = $row['username'];
echo "<h1>Welcome, $username!</h1>";

// display some travel packages
$query = "SELECT * FROM travel_packages";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
  $package_name = $row['name'];
  $description = $row['description'];
  $price = $row['price'];
  echo "<h2>$package_name</h2>";
  echo "<p>$description</p>";
  echo "<p>Price: $price</p>";
  echo "<a href='booking.php?package_id={$row['id']}'>Book now</a>";
}

// display a logout button
echo "<form action='logout.php' method='post'>";
echo "<input type='submit' name='logout' value='Logout'>";
echo "</form>";

?>
