<?php

include_once("config.php");
// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check the connection
if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

/*
 *  Fill EntryList with data from database
 */

/* $fetch = "SELECT Person_Name, Date, Mood, Entry_Text FROM Entries";
$result = mysqli_query($conn, $fetch);


$data = array();
$count = 0;
while ($enr = mysqli_fetch_assoc($result)) {
  $count++;
  $a = array($count, $enr["Person_Name"], $enr["Date"], $enr["Mood"], $enr["Entry_Text"]);
  array_push($data, $a);
}

echo json_encode($data);



<script>
  var data = <?php echo json_encode($data); ?>;
  console.log("data = " data);

  function createHtmlEntry(entry) {
    return '<li id=' + entry.Person_Name + 'class="entryitem center">' + 
              '<div>' + 
                '<p>' + entry.Person_Name + ' am ' + entry.Date + '</p>' + 
                '<p>' + entry.Entry_Text + '</p>' + 
              '</div>' + 
            '</li>';
    console.log("entry = "entry);
  }

  var entryList = document.querySelector('.entrylist');
  data.forEach(function(entry) {
    var entryHTML = createHtmlEntry(entry);
    entryList.innerHTML += entryHTML;
  });
</script> */

/* 
 *  What happens when you click "Submit"
 */

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

  // Use prepared statement to insert data into the database
  $stmt = $conn->prepare("INSERT INTO Entries (Person_Name, Date, Mood, Entry_Text) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $date, $mood, $entry);

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

mysqli_close($conn);

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

?>