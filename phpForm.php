<?php
  // The global $_POST variable allows you to access the data sent with the POST method by name
  // To access the data sent with the GET method, you can use $_GET
  $date = htmlspecialchars($_POST['date']);
  $name  = htmlspecialchars($_POST['name']);
  $entry  = htmlspecialchars($_POST['entry']);

  echo  $date <br>;
  echo  $name <br>;
  echo  $entry;

/*<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $date = $_POST["date"];
  $name = $_POST["name"];
  $entry = $_POST["entry"];

  // Validate data (you may want to add more validation)
  if (empty($date) || empty($name) || empty($entry)) {
      echo "Please fill out all fields.";
  } else {
      // Display the new entry
      echo '<li class="entryitem center">';
      echo '<div>';
      echo "<p># $name am $date</p>";
      echo "<p>$entry</p>";
      echo '</div>';
      echo '</li>';
  }
}
?>*/

?>