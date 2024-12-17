<?php
include('connect_to_db.php');

// Initialize variables
$name = $date = $package_desc = $price = $duration = $availability = $image = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $package_desc = $_POST['package_desc'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $availability = $_POST['availability'];
    $date = $_POST['Package_Date'];


    // Handle image upload

    if ($_FILES['image']['error'] == 0) {
        // Debugging: output the image size
        echo "Image file size: " . $_FILES['image']['size'] . " bytes"; 
        
        // Generate a unique filename for the image (to avoid overwriting files with same name)
        $image_name = uniqid() . "_" . $_FILES['image']['name'];
        $target_dir = "C:/xampp/htdocs/week8/packages/"; // Directory where images will be stored
        $target_file = $target_dir . $image_name;

        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Successfully moved image, now store its path in the database
            $image_path = "images/" . $image_name;
            echo "Image uploaded successfully: " . $image_path;
        } else {
            echo "Error uploading image.";
            exit;
        }
    } else {
        echo "Error uploading image: " . $_FILES['image']['error'];
        exit;
    }

    // Insert package into database
    $sql = "INSERT INTO packages (PACKAGE_NAME, PACKAGE_DESC, PACKAGE_PRICE, PACKAGE_DURATION, PACKAGE_AVAILABILITY, PACKAGE_DATE, PACKAGE_IMG_PATH) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    echo "Duration: $duration"; 
    $stmt->bind_param('ssdssss', $name, $package_desc, $price, $duration, $availability, $date , $image_path);

    if ($stmt->execute()) {
        echo "New package added successfully.";
    } else {
        echo "Error: " . $stmt->error;
        echo "SQL Error: " . $conn->error; 
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        form {
            background: #fff;
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"], 
        input[type="number"], 
        input[type="date"], 
        textarea, 
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[type="file"] {
            padding: 5px;
        }

        textarea {
            height: 80px;
            resize: none;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Add New Package</h1>

    <form action="add_package.php" method="POST" enctype="multipart/form-data">
        <label for="name">Package Name:</label>
        <input type="text" name="name" required>

        <label for="package_desc">Description:</label>
        <textarea name="package_desc" required></textarea>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required>

        <label for="duration">Duration:</label>
        <input type="text" name="duration" required>

        <label for="availability">Availability:</label>
        <select name="availability" required>
            <option value="Available">Available</option>
            <option value="Not Available">Not Available</option>
        </select>

        <label for="Package_Date">Package Date:</label>
        <input type="date" id="Package_Date" name="Package_Date" required>

        <label for="image">Image:</label>
        <input type="file" name="image" required>

        <input type="submit" value="Add Package">
    </form>

    <a href="menuAdmin.php">Go back to Menu Admin</a>

</body>
</html>
