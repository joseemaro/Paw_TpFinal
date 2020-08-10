var window = window || {},
    document = document || {},
    console = console || {};
document.addEventListener("DOMContentLoaded", function() {

    //validate username
    validate_username = document.querySelector(".usernamejs");
    validate_username.addEventListener("blur", function() {
        var username = /^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9. ]+(?<![_.])$/;
        if (username.exec(validate_username.value) || (validate_username.value === "")) {
            validate_username.style.border = "#ffffff";
            validate_username.style.background = "#ffffff";
            var pass = document.getElementById("user-invalid");
            pass.style.display= "none";

        } else {
            validate_username.style.background = "#e05f5f";

            var pass = document.getElementById("user-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";

            var text = document.getElementById("textt");
            text.removeAttribute("disabled");
        }
    });

    //validate name
    validate_name = document.querySelector(".namejs");
    validate_name.addEventListener("blur", function() {
        var name = /^[a-zA-Z ]{3,30}$/;
        if (name.exec(validate_name.value) || (validate_name.value === "")) {
            validate_name.style.border = "#ffffff";
            validate_name.style.background = "#ffffff";
            var pass = document.getElementById("name-invalid");
            pass.style.display= "none";
        } else {
            validate_name.style.background = "#e05f5f";
            var pass = document.getElementById("name-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate surname
    validate_surname = document.querySelector(".surnamejs");
    validate_surname.addEventListener("blur", function() {
        var surname = /^[a-zA-Z ]{3,30}$/;
        if (surname.exec(validate_surname.value) || (validate_surname.value === "")) {
            validate_surname.style.border = "#ffffff";
            validate_surname.style.background = "#ffffff";
            var pass = document.getElementById("surname-invalid");
            pass.style.display= "none";
        } else {
            validate_surname.style.background = "#e05f5f";
            var pass = document.getElementById("surname-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate that the user is adult, that it was born at least 18 years ago
    validate_born = document.querySelector(".bornjs");
    validate_born.addEventListener("blur", function(event) {
        var hoy = new Date();
        var meshoy = hoy.getMonth() + 1;
        var diahoy = hoy.getDate();
        if (meshoy < 10) {
            meshoy = '0' + meshoy;
        }
        if (diahoy < 10) {
            diahoy = '0' + diahoy;
        }
        var formato_hoy = (hoy.getFullYear() - 18) + "-" + meshoy + "-" + diahoy;
        if (validate_born.value === "") {
            validate_born.style.background = "#ffffff";
            validate_born.style.border = "#ffffff";
            var pass = document.getElementById("born-invalid");
            pass.style.display= "none";
        } else if (validate_born.value > formato_hoy) {
            var pass = document.getElementById("born-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";

        } else {
            validate_born.style.background = "#ffffff";
            validate_born.style.border = "#ffffff";
            var pass = document.getElementById("born-invalid");
            pass.style.display= "none";
        }
    });

    //validate identification number
    validate_identificationNumber = document.querySelector(".identificationNumberjs");
    validate_identificationNumber.addEventListener("blur", function() {
        var identificationNumber = /^\d{8}(?:[-\s]\d{4})?$/;
        if (identificationNumber.exec(validate_identificationNumber.value) || (validate_identificationNumber.value === "")) {
            validate_identificationNumber.style.border = "#ffffff";
            validate_identificationNumber.style.background = "#ffffff";
            validate_identificationNumber.style.background = "#e05f5f";
            var pass = document.getElementById("dni-invalid");
            pass.style.display= "none";
        } else {
            validate_identificationNumber.style.background = "#e05f5f";
            var pass = document.getElementById("dni-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate phone
    validate_phone = document.querySelector(".phonejs");
    validate_phone.addEventListener("blur", function() {
        var phone = /^(?:(?:00)?549?)?0?(?:11|[2368]\d)(?:(?=\d{0,2}15)\d{2})??\d{8}$/;
        if (phone.exec(validate_phone.value) || (validate_phone.value === "")) {
            validate_phone.style.border = "#ffffff";
            validate_phone.style.background = "#ffffff";
            var pass = document.getElementById("tel-invalid");
            pass.style.display= "none";
        } else {
            validate_phone.style.background = "#e05f5f";
            var pass = document.getElementById("tel-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate address
    validate_address = document.querySelector(".addressjs");
    validate_address.addEventListener("blur", function() {
        var address = /^[a-zA-Z0-9 ]{3,50}$/;
        /*var address = /^[a-zA-Z0-9À-ÿ\u00f1\u00d1\u00E0-\u00FC ]{3,50}$/;*/
        if (address.exec(validate_address.value) || (validate_address.value === "")) {
            validate_address.style.border = "#ffffff";
            validate_address.style.background = "#ffffff";
            var pass = document.getElementById("dir-invalid");
            pass.style.display= "none";
        } else {
            validate_address.style.background = "#e05f5f";
            var pass = document.getElementById("dir-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate email
    validate_email = document.querySelector(".emailjs");
    validate_email.addEventListener("blur", function() {
        var email = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (email.exec(validate_email.value) || (validate_email.value === "")) {
            validate_email.style.border = "#ffffff";
            validate_email.style.background = "#ffffff";
            var pass = document.getElementById("email-invalid");
            pass.style.display= "none";
        } else {
            validate_email.style.background = "#e05f5f";
            var pass = document.getElementById("email-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate pathologies
    validate_pathology = document.querySelector(".pathologyjs");
    validate_pathology.addEventListener("blur", function() {
        var path = /^[a-zA-Z0-9+-.: ]{3,70}$/;
        if (path.exec(validate_pathology.value) || (validate_pathology.value === "")) {
            validate_pathology.style.border = "#ffffff";
            validate_pathology.style.background = "#ffffff";
            var pass = document.getElementById("pathology-invalid");
            pass.style.display= "none";

        } else {
            validate_pathology.style.background = "#e05f5f";
            var pass = document.getElementById("pathology-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate description
    validate_description = document.querySelector(".descriptionjs");
    validate_description.addEventListener("blur", function() {
        var description = /^[a-zA-Z0-9?!¡¿.,; ]{3,300}$/;
        if (description.exec(validate_description.value) || (validate_description.value === "")) {
            validate_description.style.border = "#ffffff";
            validate_description.style.background = "#ffffff";
            var pass = document.getElementById("description-invalid");
            pass.style.display= "none";
        } else {
            validate_description.style.background = "#e05f5f";
            var pass = document.getElementById("description-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate calendar
    validate_calendar = document.querySelector(".calendarjs");
    validate_calendar.addEventListener("blur", function() {
        var calendar = /^[a-zA-Z0-9@., ]{3,100}$/;
        if (calendar.exec(validate_calendar.value) || (validate_calendar.value === "")) {
            validate_calendar.style.border = "#ffffff";
            validate_calendar.style.background = "#ffffff";
            var pass = document.getElementById("calendar-invalid");
            pass.style.display= "none";
        } else {
            validate_calendar.style.background = "#e05f5f";
            var pass = document.getElementById("calendar-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });



});