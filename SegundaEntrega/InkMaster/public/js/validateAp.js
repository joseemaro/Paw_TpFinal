var window = window || {},
    document = document || {},
    console = console || {};
document.addEventListener("DOMContentLoaded", function() {

    //validar terminos
    validate_terms = document.querySelector(".termsjs");
    validate_terms.addEventListener("click", function() {
        terms = document.getElementById("send-btn");
        if (validate_terms.checked) {
            terms.removeAttribute("disabled");
        }else{
            terms.setAttribute("disabled", "");
        }
    });

    //validate that the appointment is in a future
    validate_date = document.querySelector(".datejs");
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

        if (validate_date.value === "") {
            validate_date.style.background = "#ffffff";
            validate_date.style.border = "#ffffff";
        } else if (validate_date.value < formato_hoy) {
            validate_date.style.background = "#e05f5f";
            validate_date.style.border = "#e05f5f";
            var input = document.getElementById('date');
            var elem = document.createElement('div');
            elem.id = 'notify';
            elem.style.display = 'block';
            elem.style.color = "#CD0808";
            var form = document.getElementById('form');
            form.insertBefore(elem, form.children[3]);
            elem.textContent = '*La fecha seleccionada debe ser valida*';
            elem.className = 'error';
            elem.style.display = 'block';

        } else {
            validate_date.style.background = "#ffffff";
            validate_date.style.border = "#ffffff";
        }
    });

    //validar terminos
    validate_pathology = document.querySelector(".pathologyjs");
    validate_pathology.addEventListener("blur", function() {
        var path = /^[a-zA-Z0-9+-.: ]{3,70}$/;
        if (path.exec(validate_pathology.value) || (validate_pathology.value === "")) {
            validate_pathology.style.border = "#ffffff";
            validate_pathology.style.background = "#ffffff";
        } else {
            validate_pathology.style.background = "#e05f5f";
        }
    });

});