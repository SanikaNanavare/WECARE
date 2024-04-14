<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "127.0.0.1";
    $username = "localhost";
    $password = "Sakshi@123";
    $db_name = "wecare";
    $conn = new mysqli($servername, $username, $password, $db_name, 3308);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the required fields are set in the $_POST array
    if (isset($_POST['username'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        // Check if the username and email exist in the database
        $checkQuery = "SELECT * FROM register WHERE username='$username' AND email='$email'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            // Update the user's row with the new subject and message
            $updateQuery = "UPDATE register SET subject='$subject', message='$message' WHERE username='$username' AND email='$email'";
            
            if ($conn->query($updateQuery) === TRUE) {
                echo "Record updated successfully";
                header("Location: index.html");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
                $_SESSION['error_message'] = "Error updating record: " . $conn->error;
                header("Location: feedback.html");
                exit();
            }
        } else {
            echo "User not found. Please check your username and email.";
            $_SESSION['error_message'] = "User not found. Please check your username and email.";
            header("Location: feedback.html");
            exit();
        }
    } else {
        echo "Please fill in all the required fields.";
        $_SESSION['error_message'] = "Please fill in all the required fields.";
        header("Location: feedback.html");
        exit();
    }

    $conn->close();
} else {
    echo "Invalid request method.";
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: feedback.html");
    exit();
}
?>
