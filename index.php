<!DOCTYPE html>
<html lang="de" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <title>Dressler's Convectores</title>
</head>

<body>
  <!-- <div class="wrapper">
    <div class="left"></div>
  <div class="main"> -->
    <header>
      <h1 class="title">WÜD-2118's persönliches Gästebuch</h1>
    </header>
  
    <div class="formcontainer">
      <form method="post" action="phpForm.php">
        <div class="formrow">
          <div class="date">
            <label for="date">Datum:</label>
            <span class="error">
              <?php echo /* '* ' */ isset($dateErr) ? $dateErr : '';?>
            </span>
            <input type="date" id="date" name="date">
          </div>
          <div class="name">
            <label for="name">Name:</label>
            <span class="error">
              <?php echo /* '* ' */ isset($nameErr) ? $nameErr : '';?>
            </span>
            <input type="text" id="name" name="name" placeholder="Dein Name ">
          </div>
        </div>
        <div class="formrow">
          <div class="mood">
            <label for="mood">Wie war deine Fahrt?</label>
            <span class="error">
              <?php echo /* '* ' */ isset($moodErr) ? $moodErr : '';?>
            </span> <br>
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
          </div>
        </div>
        <div class="underline">
          <label for="entry">Dein Eintrag:</label>
          <span class="error">
            <?php echo /* '* ' */ isset($entryErr) ? $entryErr : '';?>
          </span>
          <textarea name="entry" id="entry" rows="10" placeholder="Schreib was du im Kopf hast... ✏️"></textarea><br>
        </div>
        <div>
          <input class="btn btn-outline-primary shadow-none submit" type="submit" name="submitForm">
        </div>
      </form>
    </div>
  
    <hr class="solid"><br>
  
    <h2 class="lower-section">Gästebucheinträge</h2>
  
    <div class="journal">
      <ul class="entrylist">
        <li id="1" class="entryitem center">
          <div>
            <p class="emoji">&#128513;&nbsp;</p>
            <p class="id-line">#Name am #Datum</p>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
              sed diam nonumy eirmod tempor invidunt ut labore et dolore
              magna aliquyam erat, sed diam voluptua. At vero eos et
              accusam et</p>
          </div>
        </li>
      </ul>
    </div>
  <!-- </div>

  <div class="right"></div>
  </div> -->
  
  

  <?php
    include_once("config/config.php");
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

</body>

</html>