<?php
include('connect_to_db.php');

$sql = "SELECT * FROM packages";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            background-image: url("welcomePage.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            backdrop-filter: blur(5px);
            display: flex;
            flex-direction: column;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding-top: 5px;
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

        .header-top ul li {
            position: relative;
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

        .header {
            text-align: center;
            color: white;
            font-size: 20px;
            width: 100%;
            font-family: "Montserrat", sans-serif;
            text-shadow: 2px 2px 40px black;
            background-color: rgba(31, 48, 62, 0);
            padding-top:30px;
        }

        .top-text{
            color:white;
            font-size: 14px;
            width: 100%;
            padding-bottom: 20px;
            text-align: center;
            font-family: "poppins", sans-serif;
        }

        .package-card {
            background: #fafafa;
            min-height: 225px;
            border-radius: 8px;
            box-shadow: 0 10px 20px #505050;
            overflow: hidden;
            margin: 20px;
            width: 30%;
            transition: transform 0.3s;
            display: flex;
            flex-direction: row;
            align-items: stretch; 
        }
        .package-card:hover {
            transform: scale(1.05);
        }

        .package-img {
            flex: 5; 
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .package-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .package-details {
            flex: 5; 
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .package-details h3 {
            margin: 0;
            color: #454f57;
            font-family: "Montserrat", sans-serif;
        }

        .package-details p {
            color: #454f57;
            margin: 5px 0;
            font-size: 12px;
            font-family: "poppins", sans-serif;
        }

        .package-price {
            flex: 2; 
            background-color: #598bd0;
            color: white;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: 100%; 
        }
        .package-price .price {
            font-size: 18px;
            font-weight: bold;
            font-family: "Montserrat", sans-serif;
        }

        .btn {
            display: block;
            text-align: center;
            background: #1e90ff;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background: #005fbb;
        }

        /* CSS for unavailable package cards */
        .package-card.unavailable {
            opacity: 0.5; /* Make the card appear grayed out */
            pointer-events: none; /* Disable mouse interactions */
            cursor: not-allowed; /* Change cursor to indicate unavailability */
        }

        @media (max-width: 768px) {
            .package-card {
                width: 100%; 
                margin: 10px 0; 
            }
        }

    </style>
    <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
    rel="stylesheet">
</head>
<body>

    <div class="header-top">
        <ul>
            <li><a href="http://localhost/week8/homepage/welcome.html#home">HOME</a></li>
        </ul>
    </div>

    <div class="header">
        <h1 style="text-align: center; margin-top: 20px;">All Travel Packages</h1>
    </div>

    <div class="container">
        <div class="top-text">Here we offer packages holiday for the perfect traveller who are going to travel with many member</div>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $image_src = !empty($row['PACKAGE_IMG_PATH']) ? $row['PACKAGE_IMG_PATH'] : "https://via.placeholder.com/300x200?text=No+Image";
                $duration = !empty($row['PACKAGE_DURATION']) ? htmlspecialchars($row['PACKAGE_DURATION']) : "N/A";
                $availability = !empty($row['PACKAGE_AVAILABILITY']) ? htmlspecialchars($row['PACKAGE_AVAILABILITY']) : "N/A";
                $isAvailable = strtolower($availability) === "available"; // Check availability status
                
                // CSS class to visually disable unavailable packages
                $cardClass = $isAvailable ? "package-card" : "package-card unavailable";
                $onclick = $isAvailable ? "onclick=\"window.location.href='view_package.php?PACKAGE_ID={$row['PACKAGE_ID']}'\"" : ""; // Disable click for unavailable

                echo '<div class="' . $cardClass . '" ' . $onclick . '>
                        <div class="package-img">
                            <img src="' . $image_src . '" alt="' . htmlspecialchars($row['PACKAGE_NAME']) . '">
                        </div>
                        <div class="package-details">
                            <h3>' . htmlspecialchars($row['PACKAGE_NAME']) . '</h3>
                            <p>' . htmlspecialchars($row['PACKAGE_DESC']) . '</p>
                            <p>Duration: ' . $duration . '</p>
                            <p>Availability: ' . $availability . '</p>
                        </div>
                        <div class="package-price">
                            <p class="price">$' . htmlspecialchars($row['PACKAGE_PRICE']) . '</p>
                        </div>
                      </div>';
            }
        } else {
            echo "<p style='text-align: center;'>No packages available.</p>";
        }

        $conn->close();
        ?>

    </div>
</body>
</html>
