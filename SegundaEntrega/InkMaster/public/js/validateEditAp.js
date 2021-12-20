var window = window || {},
    document = document || {},
    console = console || {};
document.addEventListener("DOMContentLoaded", function() {

    
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
            validate_date.style.background = "#e05f5f";
            validate_date.style.border = "#e05f5f";
            var pass = document.getElementById("date-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        } else if (validate_date.value < formato_hoy) {
            validate_date.style.background = "#e05f5f";
            validate_date.style.border = "#e05f5f";
            
            var pass = document.getElementById("date-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";

        } else {
            validate_date.style.background = "#ffffff";
            validate_date.style.border = "#ffffff";
            var pass = document.getElementById("date-invalid");
            pass.style.display= "none";
        }
    });

    //validate hour
    validate_hour = document.querySelector(".hourjs");
    validate_hour.addEventListener("blur", function() {
        var hour=/^([0][9]|[1][0-7])[\:]([0-5][0-9])[\:]*([0-5][0-9])*$/;
        if (hour.exec(validate_hour.value) || (validate_hour.value === "")) {
            validate_hour.style.border = "#ffffff";
            validate_hour.style.background = "#ffffff";
            var pass = document.getElementById("hour-invalid");
            pass.style.display= "none";
        } else {
            validate_hour.style.background = "#e05f5f";
            var pass = document.getElementById("hour-invalid");
            pass.style.display= "block";
            pass.style.color= "#CD0808";
        }
    });

    



});