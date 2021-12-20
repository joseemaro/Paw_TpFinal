
document.addEventListener("DOMContentLoaded", function() {
    const btnMenu = document.querySelector("#btnMenu");
    const menu = document.querySelector("#menu");
    btnMenu.addEventListener("click", function() {
        menu.classList.toggle("show");
    });

    const subMenuBtn = document.querySelectorAll(".submenu-btn");
    for ( let i = 0; i < subMenuBtn.length; i++ ) {
        subMenuBtn[i].addEventListener("click", function() {
            if ( window.innerWidth < 1024 ) {
                const subMenu = this.nextElementSibling;
                const height = subMenu.scrollHeight;
                if ( subMenu.classList.contains("display") ) {
                    subMenu.classList.remove("display");
                    subMenu.removeAttribute("style");
                } else {
                    subMenu.classList.add("display");
                    subMenu.style.height = height + "px";
                }
            }
        });
    }
});
