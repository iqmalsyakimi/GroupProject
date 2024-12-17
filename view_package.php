<?php
session_start();
include('dbconn.php');



if (isset($_GET['PACKAGE_ID']) && is_numeric($_GET['PACKAGE_ID'])) {
    $package_id = $_GET['PACKAGE_ID'];

    $sql = "SELECT * FROM packages WHERE PACKAGE_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $package_id);  
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        //putting data in local variables using query 
        $row = $result->fetch_assoc();
        // Retrieve package details
        $name = htmlspecialchars($row['PACKAGE_NAME']);
        $package_desc = htmlspecialchars($row['PACKAGE_DESC']);
        $price = htmlspecialchars($row['PACKAGE_PRICE']);
        $duration = htmlspecialchars($row['PACKAGE_DURATION']);
        $availability = htmlspecialchars($row['PACKAGE_AVAILABILITY']);
        $date = htmlspecialchars($row['PACKAGE_DATE']);
        $image_path = htmlspecialchars($row['PACKAGE_IMG_PATH']) ?: "https://via.placeholder.com/300x200?text=No+Image";


        //setting session variables
        $_SESSION['package_name'] = $name;
        $_SESSION['package_desc'] = $package_desc;
        $_SESSION['package_price'] = $price;
        $_SESSION['package_duration'] = $duration;
        $_SESSION['package_availability'] = $availability;
        $_SESSION['package_date'] = $date;

    } else {
        echo "<p>Package not found.</p>";
        exit;
    }

    $stmt->close();
} else {
    echo "<p>Invalid package ID.</p>";
    exit;
}
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
            background-image: url("welcomePage.jpg");
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
            min-height: 750px;
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
            margin: 20px auto 20px auto;
            font-family: 'montserat', sans-serif;
        }

        .book-btn {
            
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

        .book-btn:hover {
            background-color:#6998d5;
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
            <li><a href="#">HOME</a></li>
        </ul>
    </div>
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
            <a href="/Group Proj/page lain/week8/week8/booking/booking.php?PACKAGE_ID=<?php echo $package_id; ?>" class="book-btn">Book Now</a>
        </div>
    </div>
</body>
</html>
