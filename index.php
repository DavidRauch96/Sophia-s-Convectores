<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Dressler's Convectores</title>
  </head>
  <body>

    <div class="add-entry">
      <div class="formcontainer">
        <div class="content">
          <h1>Dein Eintrag</h1>
          <form method="post"action="phpForm.php">
            <div class="formrow">
              <div class="date">
                <label for="date">Datum:</label>
                <span class="error">* <?php echo isset($dateErr) ? $dateErr : '';?></span>
                <input type="date" id="date" name="date">
              </div>
              <div class="name">
                <label for="name">Dein Name:</label>
                <span class="error">* <?php echo isset($nameErr) ? $nameErr : '';?></span>
                <input type="text" id="name" name="name">
              </div>
            </div>
            <div class="formrow">
              <div class="mood">
                <label for="mood">Mood:</label>
                <span class="error">* <?php echo isset($moodErr) ? $moodErr : '';?></span> <br>
                <div class="btn-group">
                  <input type="hidden" id="selectedMood" name="selectedMood" value="">
                  <button type="button" class="btn btn-outline-primary mood-btn" name="amazing" value="amazing" onclick="setMood('amazing')">&#128513;</button>
                  <button type="button" class="btn btn-outline-primary mood-btn" name="happy" value="happy" onclick="setMood('happy')">&#128578;</button>
                  <button type="button" class="btn btn-outline-primary mood-btn" name="neutral" value="neutral" onclick="setMood('neutral')">&#128528;</button>
                  <button type="button" class="btn btn-outline-primary mood-btn" name="sad" value="sad" onclick="setMood('sad')">&#128577;</button>
                  <button type="button" class="btn btn-outline-primary mood-btn" name="angry" value="angry" onclick="setMood('angry')">&#128545;</button>
                </div>
              </div>

            </div>
            <div class="underline">
              <label for="entry">Dein Eintrag</label>
              <span class="error">* <?php echo isset($entryErr) ? $entryErr : '';?></span>
              <textarea name="entry" id="entry" rows="10"></textarea><br>
            </div>
            <div>
              <!--<button type="button" class="btn btn-outline-primary">Submit</button>-->
              <input class="btn btn-outline-primary submit" type="submit" name="submitForm">
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="journal">
      <ul class="entrylist">
        <li id="1" class="entryitem center">
          <div>
            <p>#Name am #Datum</p>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, 
            sed diam nonumy eirmod tempor invidunt ut labore et dolore 
            magna aliquyam erat, sed diam voluptua. At vero eos et 
            accusam et</p>
          </div>
          
        </li>
        <li id="2" class="entryitem center">
          <div>
            <p>#Name am #Datum</p>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
            sed diam nonumy eirmod tempor invidunt ut labore et dolore
            magna aliquyam erat, sed diam voluptua. At vero eos et
            accusam et</p>
          </div>
        </li>
      </ul>
    </div>


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

    $fetch = "SELECT Person_Name, Date, Mood, Entry_Text FROM Entries";
    $result = mysqli_query($conn, $fetch);


    $data = array();
    $count = 0;
    while ($enr = mysqli_fetch_assoc($result)) {
      $count++;
      $a = array('Count' => $count, 'Person_Name' => $enr["Person_Name"], 'Date' => $enr["Date"], 'Mood' => $enr["Mood"], 'Entry_Text' => $enr["Entry_Text"]);
      array_push($data, $a);
    }

    /* echo json_encode(array_values($data)); */
    ?>

    <script>
      var data = <?php echo json_encode($data); ?>;
      console.log();

      function createHtmlEntry(entry) {
        return '<li id=' + entry.Person_Name + ' class="entryitem center">' + 
                  '<div>' + 
                    '<p>' + entry.Person_Name + ' am ' + entry.Date + '</p>' + 
                    '<p>' + entry.Entry_Text + '</p>' + 
                  '</div>' + 
                '</li>';
        console.log("entry = " + entry);
      }

      var entryList = document.querySelector('.entrylist');
      data.forEach(function(entry) {
        var entryHTML = createHtmlEntry(entry);
        entryList.innerHTML += entryHTML;
      });
    </script>

    <script>

      // JavaScript function to set the selected mood in the hidden input field
      function setMood(mood) {
        document.getElementById('selectedMood').value = mood;
      }
    </script>

  </body>
</html>
