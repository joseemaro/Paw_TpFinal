var window = window || {},
    document = document || {},
    console = console || {};
document.addEventListener("DOMContentLoaded", function() {

    //validar terminos
    validate_up = document.querySelector(".imagejs");
    validate_up.addEventListener("click", function () {
        upBtn = document.getElementById("up-btn");
            upBtn.removeAttribute("disabled");
    });
});