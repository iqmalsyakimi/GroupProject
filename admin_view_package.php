<?php
include('connect_to_db.php');

if (isset($_POST['delete'])) {
    // Get the package ID to delete
    $package_id = $_POST['package_id'];

    // Delete the package from the database
    $sql = "DELETE FROM packages WHERE PACKAGE_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $package_id);

    if ($stmt->execute()) {
        echo "<script>alert('Package deleted successfully.'); window.location.href='admin_view_package.php';</script>";
    } else {
        echo "<script>alert('Error deleting package.'); window.location.href='admin_view_package.php';</script>";
    }

    $stmt->close();
}

// Update availability functionality
if (isset($_POST['update'])) {
    $package_id = $_POST['package_id'];
    $new_availability = $_POST['new_availability'];

    // Update the package availability in the database
    $sql = "UPDATE packages SET PACKAGE_AVAILABILITY = ? WHERE PACKAGE_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_availability, $package_id);

    if ($stmt->execute()) {
        echo "<script>alert('Package availability updated successfully.'); window.location.href='admin_view_package.php';</script>";
    } else {
        echo "<script>alert('Error updating package availability.'); window.location.href='adminview_package.php';</script>";
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
    <title>View Packages</title>
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

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        td img {
            width: 100px;
            height: auto;
            display: block;
        }

        .go-back-button {
         background-color: #4CAF50; /* Green background */
         color: white; /* White text */
          border: none; /* Remove border */
          padding: 10px 20px; /* Add padding */
          text-align: center; /* Center text */
          text-decoration: none; /* Remove underline */
          display: inline-block; /* Make it inline */
          font-size: 16px; /* Set font size */
          border-radius: 5px; /* Rounded corners */
          cursor: pointer; /* Change cursor to pointer on hover */
         transition: background-color 0.3s ease; /* Smooth background color transition */
        }

        .go-back-button:hover {
         background-color: #45a049; /* Darker green on hover */
            }

        button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #e60000;
        }

        select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        form {
            display: inline-block;
            margin-right: 10px;
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

    </style>
    <script>
        function confirmDelete(packageId) {
            if (confirm("Are you sure you want to delete this package?")) {
                document.getElementById('deleteForm_' + packageId).submit();
            }
        }
    </script>
</head>
<body>

<h1>All Packages</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Package Name</th>
            <th>Description</th>
            <th>Price (RM)</th>
            <th>Duration</th>
            <th>Availability</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch packages from the database
        $sql = "SELECT * FROM packages";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['PACKAGE_ID'] . "</td>";
                echo "<td>" . htmlspecialchars($row['PACKAGE_NAME']) . "</td>";
                echo "<td>" . htmlspecialchars($row['PACKAGE_DESC']) . "</td>";
                echo "<td>" . number_format($row['PACKAGE_PRICE'], 2) . "</td>";
                echo "<td>" . htmlspecialchars($row['PACKAGE_DURATION']) . "</td>";
                echo "<td>" . htmlspecialchars($row['PACKAGE_AVAILABILITY']) . "</td>";
                echo "<td>" . htmlspecialchars($row['PACKAGE_DATE']) . "</td>";

                // Action buttons: Delete and Update next to the package details
                echo "<td class='action-btns'>
                        <form id='deleteForm_" . $row['PACKAGE_ID'] . "' method='POST' action=''>
                            <input type='hidden' name='package_id' value='" . $row['PACKAGE_ID'] . "'>
                            <input type='hidden' name='delete' value='1'>
                            <button type='button' onclick='confirmDelete(" . $row['PACKAGE_ID'] . ")'>Delete</button>
                        </form>

                        <!-- Update Availability Form -->
                        <form method='POST' action=''>
                            <input type='hidden' name='package_id' value='" . $row['PACKAGE_ID'] . "'>
                            <input type='hidden' name='update' value='1'>
                            <label for='new_availability_" . $row['PACKAGE_ID'] . "'>Availability: </label>
                            <select name='new_availability' id='new_availability_" . $row['PACKAGE_ID'] . "'>
                                <option value='Available' " . ($row['PACKAGE_AVAILABILITY'] == 'Available' ? 'selected' : '') . ">Available</option>
                                <option value='Not Available' " . ($row['PACKAGE_AVAILABILITY'] == 'Not Available' ? 'selected' : '') . ">Not Available</option>
                            </select>
                            <button type='submit'>Update</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9' style='text-align: center;'>No packages found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<button class="go-back-button" onclick="window.location.href='menuAdmin.php'">Go Back to Menu Admin</button>


</body>
</html>
