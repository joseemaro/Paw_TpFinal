var window = window || {},
    document = document || {},
    console = console || {};
document.addEventListener("DOMContentLoaded", function() {

    
    //validate pathologies
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