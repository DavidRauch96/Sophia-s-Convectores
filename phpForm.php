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

$nameErr = $dateErr = $moodErr = $entryErr = "";
$name = $date = $mood = $entry = "";

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

  if (empty($_POST["selectedMood"])) {
    $moodErr = "Mood ist erforderlich";
  } else if ($_POST["selectedMood"] == "amazing") {
    $mood = "amazing";
  } else if ($_POST["selectedMood"] == "happy") {
    $mood = "happy";
  } else if ($_POST["selectedMood"] == "neutral") {
    $mood = "neutral";
  } else if ($_POST["selectedMood"] == "sad") {
    $mood = "sad";
  } else if ($_POST["selectedMood"] == "angry") {
    $mood = "angry";
  }

  if (empty($nameErr) && empty($dateErr) && empty($entryErr) && empty($moodErr)) {
    // Use prepared statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO Entries (Person_Name, Date, Mood, Entry_Text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $date, $mood, $entry);
  }

  // Execute the statement
  if ($stmt->execute()) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $stmt->error;
  }

  // Close the statement
  $stmt->close();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

echo "<h2>Your Input</h2>";
echo $name;
echo "<br>";
echo $date;
echo "<br>";
echo $mood;
echo "<br>";
echo $moodErr;
echo "<br>";
echo $entry;


mysqli_close($conn);
?>