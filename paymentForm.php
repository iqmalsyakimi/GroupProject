<?php
session_start(); // Ensure session is started to access session variables

// Retrieve session data
$pax = $_SESSION['pax']; // Number of passengers
$price = $_SESSION['package_price']; // Package price per passenger
$totalPrice = $pax * $price; // Calculate the total price


// Payment status
$paymentStatus = 'PAID'; // Status set to 'PAID' after confirmation

// If the form is submitted (payment confirmation)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user-inputted values
    $ownerName = $_POST['ownerName'];
    $cvv = $_POST['cvv'];
    $cardNumber = $_POST['cardNumber'];
    $expiryMonth = $_POST['expiryMonth'];
    $expiryYear = $_POST['expiryYear'];

    // Database connection (make sure to include your own connection details)
    include_once('../Login/connect_to_db.php');  // Adjust the path as needed
        //query to take latest booking id 
        $takebookingquery = "SELECT MAX(BOOKING_ID) AS max_booking_id FROM booking";
        $result = mysqli_query($conn, $takebookingquery);


if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row && $row['max_booking_id']) {
        $bookingId = $row['max_booking_id']; // Retrieve the highest BOOKING_ID
        
    } else {
        echo "No booking records found in the database."; // Handle empty table
    }

    }
     


        // Step 3: Insert payment details into the payments table
        $insertPaymentQuery = "INSERT INTO payment (final_price, payment_date, payment_status, booking_id)
                               VALUES ('$totalPrice', NOW(), '$paymentStatus', '$bookingId')";
 
        if (mysqli_query($conn, $insertPaymentQuery)) {
            // Step 4: Capture the payment_id after insertion;

            // After payment, you can redirect to a thank you page
            header('Location: thanksForm.php');
            exit(); // Ensure no further code is executed
        } else {
            echo "Error: " . mysqli_error($conn); // Error in inserting payment
        }
    

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Form</title>
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: azure;
        }

        .container {
            width: 750px;
            height: 600px;
            border: 1px solid;
            background-color: white;
            display: flex;
            flex-direction: column;
            padding: 40px;
            justify-content: space-around;
        }

        .container h1 {
            text-align: center;
        }

        .first-row {
            display: flex;
        }

        .owner {
            width: 100%;
            margin-right: 40px;
        }

        .input-field {
            border: 1px solid #999;
        }

        .input-field input {
            width: 100%;
            border: none;
            outline: none;
            padding: 10px;
        }

        .selection {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .selection select {
            padding: 10px 20px;
        }

        a {
            background-color: blueviolet;
            color: white;
            text-align: center;
            text-transform: uppercase;
            text-decoration: none;
            padding: 10px;
            font-size: 18px;
            transition: 0.5s;
        }

        a:hover {
            background-color: dodgerblue;
        }

        .cards img {
            width: 100px;
        }

        .total-price {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirm Your Payment</h1>
        <form method="POST">
            <div class="first-row">
                <div class="owner">
                    <h3>Owner</h3>
                    <div class="input-field">
                        <input type="text" name="ownerName" placeholder="Enter card owner name" required>
                    </div>
                </div>
                <div class="cvv">
                    <h3>CVV</h3>
                    <div class="input-field">
                        <input type="password" name="cvv" placeholder="Enter CVV" required>
                    </div>
                </div>
            </div>
            <div class="second-row">
                <div class="card-number">
                    <h3>Card Number</h3>
                    <div class="input-field">
                        <input type="text" name="cardNumber" placeholder="Enter card number" required>
                    </div>
                </div>
            </div>
            <div class="third-row">
                <h3>Card Expiry Date</h3>
                <div class="selection">
                    <div class="date">
                        <select name="expiryMonth" id="months" required>
                            <option value="Jan">Jan</option>
                            <option value="Feb">Feb</option>
                            <option value="Mar">Mar</option>
                            <option value="Apr">Apr</option>
                            <option value="May">May</option>
                            <option value="Jun">Jun</option>
                            <option value="Jul">Jul</option>
                            <option value="Aug">Aug</option>
                            <option value="Sep">Sep</option>
                            <option value="Oct">Oct</option>
                            <option value="Nov">Nov</option>
                            <option value="Dec">Dec</option>
                        </select>
                        <select name="expiryYear" id="years" required>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Display Total Price and Pax -->
            <div class="total-price">
                <span>Total Price (for <?php echo $pax; ?> Pax):</span>
                <span>$<?php echo number_format($totalPrice, 2); ?></span>
            </div>

            <button type="submit">Confirm Payment</button>
        </form>
    </div>
</body>
</html>
