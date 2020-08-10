var window = window || {},
    document = document || {},
    console = console || {};
document.addEventListener("DOMContentLoaded", function() {


    //validate question
    validate_question = document.querySelector(".questionjs");
    validate_question.addEventListener("blur", function() {
        var question = /^[a-zA-Z0-9?!¡¿.,; ]{3,100}$/;
        if (question.exec(validate_question.value) || (validate_question.value === "")) {
            console.log("question");
            validate_question.style.border = "#ffffff";
            validate_question.style.background = "#ffffff";
            var pass = document.getElementById("question-invalid");
            pass.style.display= "none";
        } else {
            validate_question.style.background = "#e05f5f";
            var pass = document.getElementById("question-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate description
    validate_answer = document.querySelector(".answerjs");
    validate_answer.addEventListener("blur", function() {
        var answer = /^[a-zA-Z0-9?!¡¿.,; ]{3,300}$/;
        if (answer.exec(validate_answer.value) || (validate_answer.value === "")) {
            console.log("answer");
            validate_answer.style.border = "#ffffff";
            validate_answer.style.background = "#ffffff";
            var pass = document.getElementById("answer-invalid");
            pass.style.display= "none";
        } else {
            validate_answer.style.background = "#e05f5f";
            var pass = document.getElementById("answer-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    //validate description
    validate_description = document.querySelector(".descriptionjs");
    validate_description.addEventListener("blur", function() {

        var description = /^[a-zA-Z0-9?!¡¿.,; ]{3,300}$/;
        if (description.exec(validate_description.value) || (validate_description.value === "")) {
            console.log("ke");
            validate_description.style.border = "#ffffff";
            validate_description.style.background = "#ffffff";
            var pass = document.getElementById("summary-invalid");
            pass.style.display= "none";
        } else {
            validate_description.style.background = "#e05f5f";
            var pass = document.getElementById("summary-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });


});