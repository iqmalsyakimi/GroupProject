<?php
include('connect_to_db.php');

// Handle package deletion
if (isset($_POST['delete_package']) && isset($_POST['package_id'])) {
    $package_id = $_POST['package_id'];

    $delete_sql = "DELETE FROM packages WHERE PACKAGE_ID = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param('i', $package_id);

    if ($delete_stmt->execute()) {
        echo "<script>alert('Package deleted successfully!'); window.location.href = 'http://localhost/week8/homepage/';</script>";
    } else {
        echo "<p>Error deleting package: " . $conn->error . "</p>";
    }

    $delete_stmt->close();
}

// Fetch all packages for listing
$sql = "SELECT * FROM packages";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Details</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0 0 50px;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(5px);
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            padding-bottom: 50px;
            background-image: url("images/welcomePage.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .package-details-container {
            max-width: 50%;
            margin: 50px auto 100px auto; 
            background: rgba(255, 255, 255, 0.85); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            min-height: 700px;
            display: flex;
            flex-direction: column;
        }

        .package-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .package-details {
            padding: 0 20px 0 20px ;
            text-align: center;
        }

        .package-details h1 {
            color: #333;
            font-family: 'Montserrat', sans-serif;
            text-shadow: 2px 2px 50px black;
        }

        .package-details p {
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px auto 20px auto;
            font-family: 'Montserrat', sans-serif;
        }

        .btn {
            padding: 10px 18px;
            background-color: #0f4d92;
            color: white;
            text-decoration: none;
            border-radius: 100px;
            border-color: white;
            border-width: 10px ;
            transition: background-color 0.3s ease;
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
        }

        .btn:hover {
            background-color:#6998d5;
        }

        .delete-btn {
            background-color: #ff4d4d;
        }

        .delete-btn:hover {
            background-color: #ff6666;
        }

        .header-top {
            padding: 43px 94px 20px 94px;
            background-color: rgba(31, 48, 62, 0.5);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        }

        .header-top ul {
            list-style: none;
            display: flex;
            gap: 35px;
            justify-content: flex-start;
            padding: 0;
            margin: 0;
        }

        .header-top ul li a {
            text-decoration: none;
            font-size: 17px;
            color: white;
            font-family: 'Poppins', sans-serif;
            transition: color 0.3s ease;
        }

        .header-top ul li a:hover {
            color: #3275c7;
        }
    </style>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
</head>
<body>
    <div class="header-top">
        <ul>
            <li><a href="http://localhost/week8/homepage/">HOME</a></li>
        </ul>
    </div>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Retrieve package details
            $package_id = htmlspecialchars($row['PACKAGE_ID']);
            $name = htmlspecialchars($row['PACKAGE_NAME']);
            $package_desc = htmlspecialchars($row['PACKAGE_DESC']);
            $price = htmlspecialchars($row['PACKAGE_PRICE']);
            $duration = htmlspecialchars($row['PACKAGE_DURATION']);
            $availability = htmlspecialchars($row['PACKAGE_AVAILABILITY']);
            $date = htmlspecialchars($row['PACKAGE_DATE']);
            $image_path = htmlspecialchars($row['PACKAGE_IMG_PATH']) ?: "https://via.placeholder.com/300x200?text=No+Image";
            ?>

            <div class="package-details-container">
                <img src="<?php echo $image_path; ?>" alt="<?php echo $name; ?>" class="package-image">
                <div class="package-details">
                    <h1><?php echo $name; ?></h1>
                    <p><?php echo $package_desc; ?></p>
                    <p><strong>Duration:</strong> <?php echo $duration; ?></p>
                    <p><strong>Price:</strong> $<?php echo $price; ?></p>
                    <p><strong>Availability:</strong> <?php echo $availability; ?></p>
                    <p><strong>Date:</strong> <?php echo $date; ?></p>
                </div>
                <div class="button-container">
                    <a href="http://localhost/week8/login/login.html" class="btn">Book Now</a>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
                        <button type="submit" name="delete_package" class="btn delete-btn">Delete</button>
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No packages available.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
