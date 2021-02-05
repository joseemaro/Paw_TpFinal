var window = window || {},
    document = document || {},
    console = console || {};
document.addEventListener("DOMContentLoaded", function() {
    // Get the modal
    var modal = document.getElementById("myModal2");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    document.querySelectorAll('.myImg').forEach(item => {
        item.addEventListener('click', event => {
          //handle click
            var contain = document.getElementsByClassName("container-img-artist")[0];
            console.log(contain);
            contain.removeAttribute("width");
            contain.removeAttribute("margin");
            contain.removeAttribute("display");
            contain.removeAttribute("flex-wrap");
            contain.removeAttribute("justify-content");
            
            item.style.display="block";
            var modalImg = document.getElementById("img02");
            modalImg.src = item.src;
            var captionText = document.getElementById("caption2");
            captionText.innerHTML = item.alt;
        })
      })

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close2")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
    modal.style.display = "none";
    }

});