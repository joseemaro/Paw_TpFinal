var window = window || {},
    document = document || {},
    console = console || {};
document.addEventListener("DOMContentLoaded", function() {

    //validate pathologies
    validate_pathology = document.querySelector(".pathologyjs");
    if (validate_pathology != null){
        validate_pathology.addEventListener("blur", function() {
            var path = /^[a-zA-Z0-9+-.: À-ÿ\u00f1\u00d1\u00E0-\u00FC]{3,70}$/;
            var pass = document.getElementById("illness-invalid");
            class_changes(validate_pathology,pass, path);
        });
    }

    //validate hour
    validate_hour = document.querySelector(".hourjs");
    if (validate_hour != null){
        validate_hour.addEventListener("blur", function() {
            var hour=/^([0][9]|[1][0-7])[\:]([0-5][0-9])[\:]*([0-5][0-9])*$/;
            var pass = document.getElementById("hour-invalid");
            class_changes(validate_hour,pass, hour);
        });
    }

    //validar terminos
    validate_terms = document.querySelector(".termsjs");
    if (validate_terms != null){
        validate_terms.addEventListener("click", function() {
            btn = document.getElementById("send-btn2");
            terms_checked(validate_terms,btn);
        });
    }

    //validate that the appointment is in a future
    validate_date = document.querySelector(".datejs");
    if (validate_date != null){
        validate_date.addEventListener("blur", function(event) {
            var hoy = new Date();
            var mes;
            var meshoy = hoy.getMonth() + 1;
            var diahoy = hoy.getDate();
            if (meshoy < 10) {
                meshoy = '0' + meshoy;
            }
            if (diahoy < 10) {
                diahoy = '0' + diahoy;
            }
            var formato_hoy = hoy.getFullYear() + "-" + meshoy + "-" + diahoy;
            var pass = document.getElementById("date-invalid");
            class_change_date(validate_date,pass,formato_hoy);
        });
    }


     //validate question
     validate_question = document.querySelector(".questionjs");
     if (validate_question != null){
        validate_question.addEventListener("blur", function() {
            var question = /^[a-zA-Z0-9?!¡¿.,; À-ÿ\u00f1\u00d1\u00E0-\u00FC]{3,100}$/;
            var pass = document.getElementById("question-invalid");
            class_changes(validate_question,pass, question);
        });
    }
 
     //validate description
     validate_answer = document.querySelector(".answerjs");
     if (validate_answer != null){
        validate_answer.addEventListener("blur", function() {
            var answer = /^[a-zA-Z0-9?!¡¿.,; À-ÿ\u00f1\u00d1\u00E0-\u00FC]{3,300}$/;
            var pass = document.getElementById("answer-invalid");
            class_changes(validate_answer,pass, answer);
        });
    }

     //validate description
     validate_description = document.querySelector(".descriptionjs");
     if (validate_description != null){
        validate_description.addEventListener("blur", function() {
            var description = /^[a-zA-Z0-9?!¡¿.,; À-ÿ\u00f1\u00d1\u00E0-\u00FC]{3,300}$/;
            var pass = document.getElementById("summary-invalid");
            class_changes(validate_description,pass, description);
        });
    }

    //validar img
    validate_up = document.querySelector(".imagejs");
    if (validate_up != null) {
        validate_up.addEventListener("click", function () {
            upBtn = document.getElementById("up-btn");
            upBtn.removeAttribute("disabled");
        });
    }

    //validate username
    validate_username = document.querySelector(".usernamejs");
    if (validate_username != null){
        validate_username.addEventListener("blur", function() {
            var username = /^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9. ]+(?<![_.])$/;
            var pass = document.getElementById("user-invalid");
            class_changes(validate_username,pass, username);
        });
    }

    //validate password
    validate_password = document.querySelector(".passwordjs");
    if (validate_password != null){
        validate_password.addEventListener("blur", function() {
            var password = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
            var pass = document.getElementById("pass");
            class_changes(validate_password,pass, password);
        });
    }

    //validate that the confirm password is the same that the password input 
    validate_password = document.querySelector(".passwordjs");
    validate_confirmPassword = document.querySelector(".confirmPasswordjs");
    if (validate_confirmPassword != null  && validate_password != null){
        validate_confirmPassword.addEventListener("blur", function() {
            var password = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
            var pass = document.getElementById("pass-invalid");
            class_change_val_pass(validate_confirmPassword,validate_password,pass,password);
        });
    }

    //validate name
    validate_name = document.querySelector(".namejs");
    if (validate_name != null){
        validate_name.addEventListener("blur", function() {
            var name = /^[a-zA-Z ]{3,30}$/;
            var pass = document.getElementById("name-invalid");
            class_changes(validate_name,pass, name);
        });
    }
   
    //validate surname 
    validate_surname = document.querySelector(".surnamejs");
    if (validate_surname != null){
        validate_surname.addEventListener("blur", function() {
            var surname = /^[a-zA-Z ]{3,30}$/;
            var pass = document.getElementById("surname-invalid");
            class_changes(validate_surname,pass, surname);
        });
    }

    //validate that the user is adult, that it was born at least 18 years ago
    validate_born = document.querySelector(".bornjs");
    if (validate_born !=null){
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
            var formato_hoy2 = hoy.getFullYear() + "-" + meshoy + "-" + diahoy;
            var pass = document.getElementById("born-invalid");
            var pass2 = document.getElementById("born2-invalid");
            class_change_born(validate_born,pass,pass2,formato_hoy,formato_hoy2);
        });
    }
    
    //validate identification number 
    validate_identificationNumber = document.querySelector(".identificationNumberjs");
    if (validate_identificationNumber != null){
        validate_identificationNumber.addEventListener("blur", function() {
            var identificationNumber = /^\d{8}(?:[-\s]\d{4})?$/;
            var pass = document.getElementById("dni-invalid");
            class_changes(validate_identificationNumber,pass,identificationNumber);
        });
    }

    //validate phone 
    validate_phone = document.querySelector(".phonejs");
    if (validate_phone !=null){
        validate_phone.addEventListener("blur", function() {
            var phone = /^(?:(?:00)?549?)?0?(?:11|[2368]\d)(?:(?=\d{0,2}15)\d{2})??\d{8}$/;
            var pass = document.getElementById("tel-invalid");
            class_changes(validate_phone,pass,phone);
        });
    }

    //validate address
    validate_address = document.querySelector(".addressjs");
    if (validate_address !=null){
        validate_address.addEventListener("blur", function() {
            var address = /^[a-zA-Z0-9 ]{3,50}$/;
            var pass = document.getElementById("dir-invalid");
            class_changes(validate_address,pass,address);
        });
    }

    //validate email
    validate_email = document.querySelector(".emailjs");
    if (validate_email != null){
    validate_email.addEventListener("blur", function() {
        var email = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var pass = document.getElementById("email-invalid");
        class_changes(validate_email,pass,email);
        });
    }
    
    //validate calendar
    validate_calendar = document.querySelector(".calendarjs");
    if (validate_calendar != null){
        validate_calendar.addEventListener("blur", function() {
            var calendar = /^[a-zA-Z0-9@., ]{3,100}$/;
            var pass = document.getElementById("calendar-invalid");
            class_changes(validate_calendar,pass,calendar);
        });
    }


   

});

function valid_form(elem,alert){
    elem.classList.remove("invalid-input");
    elem.classList.add("valid-input");
    alert.classList.remove("show-alert");
    alert.classList.add("hide-alert");
}

function invalid_form(elem,alert){
    elem.classList.remove("valid-input");
    elem.classList.add("invalid-input");
    alert.classList.remove("hide-alert");
    alert.classList.add("show-alert");
}


function class_changes(elem, alert, regex ){
    if (regex.exec(elem.value) || (elem.value === "")) {   
        valid_form(elem,alert);
    } else {
        invalid_form(elem,alert);
    }
}


function class_change_date(elem,alert, date){
    if (elem.value < date){
        invalid_form(elem,alert);
    }else {
        valid_form(elem,alert);
    }
}


function class_change_val_pass(elem, elem2, alert,regex){
    if ((regex.exec(elem.value) && elem.value == elem2.value) || (elem.value === "")) {
        valid_form(elem,alert);
    } else {
        invalid_form(elem,alert);

    }
}

function class_change_born(elem,alert,alert2,date,date2){
    if (elem.value > date){
        if (elem.value < date2){
            elem.classList.remove("invalid-input");
            elem.classList.add("valid-input");
            alert.classList.remove("hide-alert");
            alert.classList.add("show-alert");
        }
    } else {
        valid_form(elem,alert);
    }
    
    if (elem.value > date2){
        elem.classList.remove("valid-input");
        elem.classList.add("invalid-input");
        alert2.classList.remove("hide-alert");
        alert2.classList.add("show-alert");
        alert.classList.remove("show-alert");
        alert.classList.add("hide-alert");
    }else{
        alert2.classList.remove("show-alert");
        alert2.classList.add("hide-alert");
    }
}


function terms_checked(term, button){
    if (term.checked) {
        button.removeAttribute("disabled");
        button.classList.remove("terms-uncheck");
        button.classList.add("terms-check");
    }else{
        button.setAttribute("disabled", "");
        button.classList.remove("terms-check");
        button.classList.add("terms-uncheck");
    }
}

function comprobar(obj) {
    if (obj.checked) {
        document.getElementById('pathology-txt').classList.remove("hide-area");
        document.getElementById('pathology-txt').classList.add("show-area");
    } else {
        document.getElementById('pathology-txt').classList.remove("show-area");
        document.getElementById('pathology-txt').classList.add("hide-area");
    }
}

function artists(obj) {
    if (obj.checked) {
        document.getElementById('description-artist').classList.remove("hide-area");
        document.getElementById('description-artist').classList.add("show-area");

        document.getElementById('calendar-id').classList.remove("hide-area");
        document.getElementById('calendar-id').classList.add("show-area");
    } else {
        document.getElementById('description-artist').classList.remove("show-area");
        document.getElementById('description-artist').classList.add("hide-area");

        document.getElementById('calendar-id').classList.remove("show-area");
        document.getElementById('calendar-id').classList.add("hide-area");
    }
}

