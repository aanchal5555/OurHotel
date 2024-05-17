<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $checkin = htmlspecialchars($_POST['checkin']);
    $checkout = htmlspecialchars($_POST['checkout']);
    $room_type = htmlspecialchars($_POST['room_type']);

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "roombook";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO form (name, email, phone, checkin, checkout, room_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone, $checkin, $checkout, $room_type);

        // Execute statement
        if ($stmt->execute()) {
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Booking Confirmation</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        padding: 20px;
                    }
                    .container {
                        max-width: 500px;
                        margin: 0 auto;
                        background-color: white;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    }
                    .confirmation {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='confirmation'>
                        <h2>Booking Confirmation</h2>
                        <p>Thank you, $name, for your booking.</p>
                        <p>Email: $email</p>
                        <p>Phone: $phone</p>
                        <p>Check-in Date: $checkin</p>
                        <p>Check-out Date: $checkout</p>
                        <p>Room Type: $room_type</p>
                    </div>
                </div>
            </body>
            </html>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Invalid request method.";
}
?>
