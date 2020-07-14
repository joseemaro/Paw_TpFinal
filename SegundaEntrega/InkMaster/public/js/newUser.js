function comprobar(obj) {
    if (obj.checked) {
        document.getElementById('pathology-txt').style.display = "block";
    } else {
        document.getElementById('pathology-txt').style.display = "none";
    }
}

function artists(obj) {
    if (obj.checked) {
        document.getElementById('description-artist').style.display = "block";
        document.getElementById('calendar-id').style.display = "block";
    } else {
        document.getElementById('description-artist').style.display = "none";
        document.getElementById('calendar-id').style.display = "none";
    }
}

