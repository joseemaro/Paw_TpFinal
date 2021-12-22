var window = window || {},
    document = document || {},
    console = console || {},
    id_tattoo_attribute;
document.addEventListener("DOMContentLoaded", function() {
    // Get the modal
    var modal = document.getElementById("myModal"),
        notModalImg = document.querySelectorAll('.close-modal'),
        modalNext = document.getElementsByClassName("modal-next")[0],
        modalPrevious = document.getElementById("modal-previous"),
        modalClose = document.getElementsByClassName("close")[0],
        modalImg = document.getElementById("img01"),
        captionText = document.getElementById("caption");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    document.querySelectorAll('.myImg').forEach(item => {
        item.addEventListener('click', event => {
          modal.style.display = "block";
          modalImg.src = item.src;
          captionText.innerHTML = item.alt;
            id_tattoo_attribute = item.getAttribute( "data-tattoo-id" );
        })
      })

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    modalClose.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks on any element except the modalImg, close the modal
    // notModalImg.forEach(element => {
    //     console.log( element );
    //     element.addEventListener('click', event => {
    //         modal.style.display = "none";
    //     })
    // });

    modalNext.onclick = function() {
        modal.style.display = "block";
        changeImage( id_tattoo_attribute, 'next' );
    }

    modalPrevious.onclick = function() {
        modal.style.display = "block";
        changeImage( id_tattoo_attribute, 'previous' );
    }

});

function changeImage( id_tattoo, action ) {
    console.log( action );
    $.ajax(
        {
            type: "POST",
            url: "/change_tattoo",
            dataType: "json",
            data: {
                id_tattoo: id_tattoo,
                action: action
            },
        },
    )
        .done( function( response ) {
            var modalImg = document.getElementById("img01"),
                captionText = document.getElementById("caption");

            modalImg.src = "data:image/png;base64, " + response.image;
            captionText.innerHTML = response.txt;
            id_tattoo_attribute = response.id_tattoo;
        } )
        .fail( function() {
            console.log( "error" );
        } );
}