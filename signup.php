<?php
session_start();

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
    if (isset($_POST['email'], $_POST['username'], $_POST['password'], $_POST['contact'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);

        // Perform additional validation as needed

        // Check if the username or email already exists in the database
        $checkQuery = "SELECT * FROM register WHERE username='$username' OR email='$email'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            $_SESSION['error_message'] = "Username or email already exists. Please choose a different one.";
            header("Location: signup.html");
            exit();
        }

        // Insert the user data into the database
        $insertQuery = "INSERT INTO register (email, username, password, contact) VALUES ('$email', '$username', '$password', '$contact')";
        if ($conn->query($insertQuery) === TRUE) {
            echo "inserted";
            $_SESSION['success_message'] = "Account created successfully. You can now log in.";
            // Redirect to login.html after successful sign-up
            header("Location: login.html");
            exit();
        } else {
            $_SESSION['error_message'] = "Error: " . $insertQuery . "<br>" . $conn->error;
            header("Location: signup.html");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Please fill in all the required fields.";
        header("Location: signup.html");
        exit();
    }

    $conn->close();
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: signup.html");
    exit();
}
?>
