<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
  }
  if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
        }
        .header {
            background: #6200ea;
            color: white;
            text-align: center;
            padding: 1rem;
        }
        .header h2 {
            margin: 0;
        }
        .content {
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .content p {
            font-size: 1.2rem;
            margin: 1rem 0;
            color: #333;
        }
        .content p strong {
            color: #6200ea;
        }
        .content a {
            color: #e53935;
            text-decoration: none;
            font-weight: bold;
        }
        .content a:hover {
            text-decoration: underline;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Home Page</h2>
</div>
<div class="content">
    <!-- Notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success">
            <h3>
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </h3>
        </div>
    <?php endif ?>

    <!-- Logged in user information -->
    <?php if (isset($_SESSION['username'])) : ?>
        <p>Bye bye Administrator</strong>!</p>
        <p><a href="http://localhost/week8/homepage/welcome.html">Logout</a></p>
    <?php endif ?>
</div>
                
</body>
</html>
