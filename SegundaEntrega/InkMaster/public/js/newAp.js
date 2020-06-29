function comprobar(obj) {
    if (obj.checked) {
        document.getElementById('pathology-txt').style.display = "block";
    } else {
        document.getElementById('pathology-txt').style.display = "none";
    }
};
