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

    /* header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies. */

    /* include 'auth.php';

    $authenticatedUser = authenticateUser(); */

    include_once("config/config.php");

    // Create a connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    $status = "";
    // Check the connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    } else {
      $status = "✓ Connected";
    }

    /* function authenticatePassword($password) {
      $envPassword = getenv('PASSWORD');
      return $password === $envPassword;
    } */
    
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

  <script src="script.js"></script>
  <script>

    // Encode inputdata($data) from database in 'phpForm.php' to JSON
    var data = <?php echo json_encode($data); ?>;
    reverse_data = data.reverse();

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
    reverse_data.forEach(function (entry) {
      var entryHTML = createHtmlEntry(entry);
      entryList.innerHTML += entryHTML;
    });

  </script>

  <footer>
    <p class="footertext">ⓒ - David Rauch</p>
    <p class="footertext status"> <?php echo $status ?> </p>
    <p class="footertext status">Version: v1.0.2</p>
  </footer>

</body>

</html>