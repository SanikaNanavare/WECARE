<?php
// Include your database connection file or establish a connection here
$servername = "127.0.0.1";
$username = "localhost";
$password = "Sakshi@123";
$db_name = "wecare";
$conn = new mysqli($servername, $username, $password, $db_name, 3308);

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $sugar = $_POST['sugar'];
    $bp = $_POST['bp'];
    $heartRate = $_POST['heart_rate'];
    $cholesterol = $_POST['cholesterol'];

    // Check if the username exists in the 'register' table
    $query = "SELECT * FROM register WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Username exists, insert health data into 'register' table
        $insertQuery = "UPDATE register 
                        SET sugar = '$sugar', bp = '$bp', heartRate = '$heartRate', cholesterol = '$cholesterol'
                        WHERE username = '$username'";

        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            // Set the session username after successfully updating health data
            $_SESSION['username'] = $username;
            
            // Redirect to the dashboard page
            header("Location: dashboard.php");
            exit(); // Add exit to stop script execution after redirection
        } else {
            echo "Error adding/updating health data: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error_message'] = "Invalid username";
        header("Location: track.html");
    }
    
    // Close the database connection
    mysqli_close($conn);
}
?>
