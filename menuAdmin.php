<?php
session_start();

// Include database connection file
include("connect_to_db.php");

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch admin data
$sql = "SELECT id, username, email, picture FROM admin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
        nav {
            margin: 1rem 0;
            text-align: center;
        }
        nav a {
            margin: 0 1rem;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        nav a:hover {
            color: #007BFF;
        }
        main {
            padding: 2rem;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .center {
            text-align: center;
        }
        footer {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, Admin!</h1>
    </header>
    <nav>
        <a href="admin_view_package.php">View Packages</a>
        <a href="add_package.php">Add Package</a>
        <a href="view.php">Reports</a>
        <a href="logout.php">Logout</a>
    </nav>
    <main>
        <h2>Admin Information Table</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Picture</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data for each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td><img src='{$row['picture']}' alt='Admin Picture'></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='center'>No data available</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        &copy; 2024 Admin Panel. All rights reserved.
    </footer>
</body>
</html>
