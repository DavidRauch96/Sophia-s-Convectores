<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
  <title>Feedback</title>
</head>

<body>
  <header>
    <h1 class="title">WÜD-2118's persönliches Gästebuch</h1>
  </header>
</body>

</html>

<?php

include_once("config/config.php");
// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check the connection
if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}
/* echo "Connected successfully"; */

/* 
 *  What happens when you click "Submit"
 */

$nameErr = $dateErr = $moodErr = $entryErr = "";
$name = $date = $mood = $entry = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $isValid = true;

  if (empty($_POST["name"])) {
    $nameErr = "Name ist erforderlich";
    $isValid = false;
  } else {
    $name = test_input($_POST["name"]);
  }

  if (empty($_POST["date"])) {
    $dateErr = "Datum ist erforderlich";
    $isValid = false;
  } else {
    $date = test_input($_POST["date"]);
  }

  if (empty($_POST["entry"])) {
    $entryErr = "Eintrag ist erforderlich";
    $isValid = false;
  } else {
    $entry = test_input($_POST["entry"]);
  }

  if (empty($_POST["selectedMood"])) {
    $moodErr = "Mood ist erforderlich";
    $isValid = false;
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

  if($isValid) {
    // Use prepared statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO Entries (Person_Name, Date, Mood, Entry_Text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $date, $mood, $entry);

    // Execute the statement
    if ($stmt->execute()) {
      echo '<div class="formcontainer">
        <div class="circle">
          <i class="bi bi-check-circle-fill success"></i>
          <p>Dein Eintrag wurde hinzugefügt!</p><br>
          <button class="btn btn-primary backbutton" onclick="window.location.href=\'//www.sophiasconvectores.de\';"> -> Zurück zum Gästebuch <- </button>
        </div>
      </div>';
    } else {
      echo '<div class="formcontainer">
        <div class="circle">
          <i class="bi bi-check-circle-fill failed"></i>
          <p>';
      echo "Error: " . $stmt->error;
      echo '</p><br>
          <button class="btn btn-primary backbutton" onclick="window.location.href=\'//www.sophiasconvectores.de\';"> -> Zurück zum Gästebuch <- </button>
        </div>
      </div>';
    }

    // Close the statement
    $stmt->close();
  } else {
    echo '<div class="formcontainer">
        <div class="circle">
          <i class="bi bi-check-circle-fill success"></i>
          <p>Dein Eintrag wurde hinzugefügt!</p><br>
          <button class="btn btn-primary backbutton" onclick="window.location.href=\'//www.sophiasconvectores.de\';"> -> Zurück zum Gästebuch <- </button>
        </div>
      </div>';
  }

  

  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

mysqli_close($conn);

/* echo "<h2>Your Input</h2>";
echo $name;
echo "<br>";
echo $date;
echo "<br>";
echo $mood;
echo "<br>";
echo $moodErr;
echo "<br>";
echo $entry; */

?>