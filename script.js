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

    console.log(valid);

    if (valid) {
        var password = prompt("Gib' das Passwort unter dem QR-Code ein:");
        if (password !== "17122022") {
            alert("Incorrect password!");
            e.preventDefault();
            return false;
        }
    } else {
        e.preventDefault(); // Prevent form submission if any field is invalid
    }
}

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