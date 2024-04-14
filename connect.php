<?php
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$userName = $_POST['userName'];
$email = $_POST['email'];
$passWord = $_POST['passWord']; // Hash the password
$confPassword = $_POST['confPassword'];

//db connection
$conn = new mysqli('localhost', 'root', 'Sakshi@123', 'wecare');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
    // Corrected bind_param function
    $stmt = $conn->prepare("INSERT INTO registrations (firstName, lastName, userName, email, passWord, confPassword) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstName, $lastName, $userName, $email, $passWord, $confPassword);
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>
