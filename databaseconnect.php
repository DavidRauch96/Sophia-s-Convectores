<?php
$servername = "localhost";
$database = "u123456789_mydatabase";
$username = "u123456789_myuser";
$password = "PasSw0rd123@";
// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check the connection
if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
$sql = "INSERT INTO Students (name, lastName, email) VALUES ('Tom', 'Jackson', 'tom@jackson.tld')";
if (mysqli_query($conn, $sql)) {
     echo "New record created successfully";
} else {
     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
?>