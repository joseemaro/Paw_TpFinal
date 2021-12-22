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

    //validate description
    validate_desc = document.querySelector(".descjs");
    validate_desc.addEventListener("blur", function() {
        var desc = /^[a-zA-Z0-9@,.: À-ÿ\u00f1\u00d1\u00E0-\u00FC]{3,80}$/;

        if (desc.exec(validate_desc.value) || (validate_desc.value === "")) {
            validate_desc.style.border = "#ffffff";
            validate_desc.style.background = "#ffffff";
            var pass = document.getElementById("des-invalid");
            pass.style.display= "none";
        } else {
            validate_desc.style.background = "#e05f5f";
            var pass = document.getElementById("des-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });
});