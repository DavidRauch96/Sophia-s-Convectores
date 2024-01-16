<?php

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

echo "<h2>Your Input</h2>";
echo $name;
echo "<br>";
echo $date;
echo "<br>";
echo $entry;
?>