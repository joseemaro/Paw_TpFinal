var window = window || {},
    document = document || {},
    console = console || {};
document.addEventListener("DOMContentLoaded", function() {

    make_zoom = document.querySelector(".zoom");
    make_zoom.addEventListener("click", function () {
        image = document.getElementById("zoom");
        image.style.transform = scale(2);
    });

});