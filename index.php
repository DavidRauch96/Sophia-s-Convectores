<!DOCTYPE html>
<html lang="de" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <title>Dressler's Convectores</title>
</head>

<body>
  <header>
    <h1 class="title">WÜD-2118's persönliches Gästebuch</h1>
  </header>

  <div class="formcontainer">
    <form method="post" action="phpForm.php">
      <div class="formrow">
        <div class="date">
          <label for="date">Datum:</label>
          <input type="date" id="date" name="date">
          <span class="error dateerror">
            <?php echo isset($dateErr) ? $dateErr : '';?>
          </span>
        </div>
        <div class="name">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" placeholder="Dein Name">
          <span class="error nameerror">
            <?php echo isset($nameErr) ? $nameErr : '';?>
          </span>
        </div>
      </div>
      <div class="formrow">
        <div class="mood">
          <label for="mood">Wie war deine Fahrt?</label>
          
          <div class="btn-group">
            <input type="hidden" id="selectedMood" name="selectedMood" value="">
            <button type="button" class="btn btn-outline-primary shadow-none mood-btn" name="amazing" value="amazing"
              onclick="setMood('amazing')">&#128513;</button>
            <button type="button" class="btn btn-outline-primary shadow-none mood-btn" name="happy" value="happy"
              onclick="setMood('happy')">&#128578;</button>
            <button type="button" class="btn btn-outline-primary shadow-none mood-btn" name="neutral" value="neutral"
              onclick="setMood('neutral')">&#128528;</button>
            <button type="button" class="btn btn-outline-primary shadow-none mood-btn" name="sad" value="sad"
              onclick="setMood('sad')">&#128577;</button>
            <button type="button" class="btn btn-outline-primary shadow-none mood-btn" name="angry" value="angry"
              onclick="setMood('angry')">&#128545;</button>
          </div>
          <br>
          <span class="error mooderror" aria-hidden="true">
            <?php echo isset($moodErr) ? $moodErr : '';?>
          </span>
        </div>
      </div>
      <div class="underline">
        <label for="entry">Dein Eintrag:</label>
        <textarea name="entry" id="entry" rows="10" placeholder="Schreib was du im Kopf hast... ✏️"></textarea><br>
        <span class="error entryerror" aria-hidden="true">
          <?php echo isset($entryErr) ? $entryErr : '';?>
        </span>
      </div>
      <div>
        <input class="btn btn-outline-primary shadow-none submit" id="submitbutton" type="submit" name="submitForm">
      </div>
    </form>
  </div>

  <hr class="solid"><br>

  <h2 class="lower-section">Gästebucheinträge</h2>

  <div class="journal">
    <ul class="entrylist">
      
    </ul>
  </div>

  <?php

    include_once("config/config.php");

    // Create a connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "✓";

    
    // Fill data array with entries from database
    $fetch = "SELECT Person_Name, Date, Mood, Entry_Text FROM Entries";
    $result = mysqli_query($conn, $fetch);

    $data = array();
    $count = 0;
    while ($enr = mysqli_fetch_assoc($result)) {
      $count++;
      $a = array('Count' => $count, 'Person_Name' => $enr["Person_Name"], 'Date' => $enr["Date"], 'Mood' => $enr["Mood"], 'Entry_Text' => $enr["Entry_Text"]);
      array_push($data, $a);
    }
  ?>

  <script>

    var submit = document.getElementById("submitbutton");
    submit.addEventListener("click", validate);

    function validate(e) {

      // Select input fields
      var date = document.getElementById("date");
      var name = document.getElementById("name");
      var mood = document.getElementById("selectedMood");
      var entry = document.getElementById("entry");

      // Select error fields
      var dateError = document.querySelector(".dateerror");
      var nameError = document.querySelector(".nameerror");
      var moodError = document.querySelector(".mooderror");
      var entryError = document.querySelector(".entryerror");

      var valid = true;

      // Reset previous error messages
      dateError.textContent = '';
      nameError.textContent = '';
      moodError.textContent = '';
      entryError.textContent = '';

      //Check input fields for content
      if (date.value === '') {
        dateError.setAttribute("aria-hidden", false);
        dateError.textContent = "↑ Datum ist erforderlich!";
        valid = false;
      }

      if (name.value === '') {
        nameError.setAttribute("aria-hidden", false);
        nameError.textContent = "↑ Name ist erforderlich!";
        valid = false;
      }

      if (mood.value === '') {
        moodError.setAttribute("aria-hidden", false);
        moodError.textContent = "↑ Bitte auswählen!";
        valid = false;
      }

      if (entry.value === '') {
        entryError.setAttribute("aria-hidden", false);
        entryError.textContent = "↑ Schreibe einen Eintrag!";
        valid = false;
      }

      // Prevent submission when a field is invalid
      if(valid == false) {
        e.preventDefault();
      }

      return valid;
    }
    

    // Encode inputdata($data) from database in 'phpForm.php' to JSON
    var data = <?php echo json_encode($data); ?>;

    // Create html elements for an entry in the entry list
    function createHtmlEntry(entry) {
      var parsedMood = parseMood(entry.Mood);
      var parsedDate = parseDate(entry.Date);

      return '<li id=' + entry.Person_Name + ' class="entryitem center">' +
        '<div>' +
        '<p class="emoji">' + parsedMood + '&nbsp;' + '</p>' +
        '<p class="id-line"><b>' + entry.Person_Name + '</b> am <b>' + parsedDate + '</b></p>' +
        '<p>' + entry.Entry_Text + '</p>' +
        '</div>' +
        '</li>';
    }

    // Create an entry for every row in the database
    var entryList = document.querySelector('.entrylist');
    data.forEach(function (entry) {
      var entryHTML = createHtmlEntry(entry);
      entryList.innerHTML += entryHTML;
    });

    /* 
     * Set the selected mood in the hidden input field of the mood button group (.btn-group)
     * [1st part may be obsolete because of hte following:]
     * Adds ".active" to class list of clicked button element and removes it from the other button elements (hidden input field might be obsolete)
     */
    function setMood(mood) {
      document.getElementById('selectedMood').value = mood;

      var buttons = document.querySelectorAll('.mood-btn');
      buttons.forEach(function (button) {
        button.classList.remove('active');
      });

      var clickedButton = document.querySelector('.mood-btn[value="' + mood + '"]');
      if (clickedButton) {
        clickedButton.classList.add('active');
      }
    }

    // Parse the value of column "mood" of database to utf-8 emoji
    function parseMood(mood) {
      switch (mood) {
        case 'amazing':
          return '&#128513;';
        case 'happy':
          return '&#128578;';
        case 'neutral':
          return '&#128528;';
        case 'sad':
          return '&#128577;';
        case 'angry':
          return '&#128545;';
      }
    }

    // Change the date format from YYYY-MM-DD to DD.MM.YYYY
    function parseDate(date) {
      var parts = date.split('-');
      return parts[2] + '.' + parts[1] + '.' + parts[0];
    }

  </script>

  <footer>
    <p>Version: v1.0.0</p>
  </footer>

</body>

</html>