<?php

$servername = "localhost";
$database = "u768772283_Entry_Database";
$username = "u768772283_David_Rauch";
$password = "Semmel+1996";
// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check the connection
if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

$nameErr = $dateErr = $entryErr = "";
$name = $date = $entry = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name ist erforderlich";
  } else {
    $name = test_input($_POST["name"]);
  }

  if (empty($_POST["date"])) {
    $dateErr = "Datum ist erforderlich";
  } else {
    $date = test_input($_POST["date"]);
  }

  if (empty($_POST["entry"])) {
    $entryErr = "Eintrag ist erforderlich";
  } else {
    $entry = test_input($_POST["entry"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$sql = "INSERT INTO Entries VALUES ('$name', '$date', '$entry')";
if (mysqli_query($conn, $sql)) {
     echo "New record created successfully";
} else {
     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

/*echo "<h2>Your Input</h2>";
echo $name;
echo "<br>";
echo $date;
echo "<br>";
echo $entry; */
?>