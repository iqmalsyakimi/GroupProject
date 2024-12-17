    <?php

    session_start();

    include_once('../Login/connect_to_db.php');
    $port = 3306;

    if(isset($_SESSION['package_name'])) {
        $package_name = $_SESSION['package_name'];
        $package_date = $_SESSION['package_date'];
        $package_duration = $_SESSION['package_duration'];
        $package_price = $_SESSION['package_price'];
    } else {
        echo "Package data not found.";
        exit;
    }

    // Extract duration's first character and turn it into a number
    $duration_number = intval(substr($package_duration, 0, 1)) + 1;

    // Add the duration to the package date to calculate the return date
    $start_date = new DateTime($package_date);
    $start_date->add(new DateInterval("P{$duration_number}D")); // Add duration as days
    $return_date = $start_date->format('Y-m-d');
    
    if(isset($_POST['submit'])) {
        
        $booking_date = date('Y-m-d');
        $package_id = $_SESSION['package_id'];
        $pax = $_POST['pax'];
        $_SESSION['pax'] = $pax;
        $depart_date = mysqli_real_escape_string($conn, $_POST['depart_date']);
        $return_date = mysqli_real_escape_string($conn, $_POST['return_date']);
        $totalprice = $pax * $package_price;
        $userid = $_SESSION['user_id'];

        

        $query = "INSERT INTO booking (BOOKING_DATE, PACKAGE_ID, PAX, DEPARTURE_DATE, RETURN_DATE, TOTAL_PRICE, USER_ID)
                  VALUES ('$booking_date', '$package_id', '$pax', '$depart_date', '$return_date', '$totalprice', '$userid')";

        mysqli_query($conn, $query);

        header('location: paymentForm.php');
    }
    ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Travel Booking Form</title>
          <style >/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f9;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.background {
    background-image: url('welcomePage.jpg'); /* Replace with your image URL */
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
}

.booking-form {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    padding: 20px 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

.booking-form h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #555;
}

.booking-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #444;
}

.booking-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.booking-form button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.booking-form button:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .booking-form {
        padding: 15px 20px;
    }

    .booking-form h2 {
        font-size: 20px;
    }

    .booking-form input, .booking-form button {
        font-size: 14px;
    }
}
</style>
        </head>
        <body>

            <div class="background">
                <div class="booking-form">

                    <h2>Travel Booking Form</h2>
                    <form action="" method="POST">
                        
                        <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
                        <label for="Package">Package:</label>
                        <input type="text" readonly name="package" id="package" value="<?php echo $_SESSION['package_name']; ?>" required>

                        <label for="pax">Pax:</label>
                        <input type="number" min="0"  name="pax" id="pax" required>
                   
                        <label for="depart_date">Departure Date:</label>
                        <input type="date" readonly name="depart_date" id="depart_date" value="<?php echo $_SESSION['package_date']; ?>" required >
                       
                        <label for="return_date">Return Date:</label>
                        <input type="date" readonly name="return_date" id="return_date" value="<?php echo $return_date ?>" >

                        <button type="submit" name="submit">Confirmation Booking
                        </button>


                        
                    </form>
                </div>
            </div>
        </body>
        </html>