<?php
session_start();

// Include database connection file
include("connect_to_db.php");


// Check if the form is submitted
if (isset($_POST['Submit'])) {
    // Capture values from the HTML form
    $email = $_POST['email'];
    $password = $_POST['password'];

  

    // Query to check if the user exists in the database
    $user_query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $user_result = mysqli_query($conn, $user_query);

    // If user exists, start a session and redirect to user menu
    if (mysqli_num_rows($user_result) > 0) {
        $_SESSION['username'] = $email; // or you can store another identifier

        $user_query = "SELECT id FROM user WHERE email = '$email' AND password = '$password'";
        $user_result = mysqli_query($conn, $user_query);

        $user_row = mysqli_fetch_assoc($user_result);
        $user_id = $user_row['id'];

        $_SESSION['user_id'] = $user_id;

        header("Location: http://localhost/week8/booking/booking.php");

        exit;
    } else {
        // Handle invalid login attempt
        $_SESSION['error'] = "Invalid email or password!";
        header("Location: registration.php"); // Redirect back to login
        exit;
    }
}
?>

