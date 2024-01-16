<?php

$name = $date = $entry = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $date = test_input($_POST["date"]);
  $entry = test_input($_POST["entry"]);
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