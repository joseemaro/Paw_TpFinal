var window = window || {},
    document = document || {},
    console = console || {},
    id_tattoo_attribute,
    id_artist_attribute;

document.addEventListener("DOMContentLoaded", () =>{
    openModal();

    const targetNode = document.body;
    const config = { childList: true, subtree: true };

    const observer = new MutationObserver(openModal);
    observer.observe(targetNode, config);
})

function openModal() {
    const items = document.querySelectorAll('.myImg'),
        modal = document.getElementById("myModal"),
        modalNext = document.getElementsByClassName("modal-next")[0],
        modalPrevious = document.getElementsByClassName("modal-previous")[0],
        modalClose = document.getElementsByClassName("close")[0];

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    items.forEach((item) => item.addEventListener("click", () =>{
        var modalImg = document.getElementById("img01"),
            captionText = document.getElementById("caption");

        modal.style.display = "block";
        modalImg.src = item.src;
        captionText.innerHTML = item.alt;
        id_tattoo_attribute = item.getAttribute( "data-tattoo-id" );
        id_artist_attribute = item.getAttribute( "data-artist-id" );
    }))

    // When the user clicks on <span> (x), close the modal
    modalClose.onclick = function() {
        modal.style.display = "none";
    }

    modalNext.onclick = function() {
        modal.style.display = "block";
        changeImage( 'next' );
    }

    modalPrevious.onclick = function() {
        modal.style.display = "block";
        changeImage( 'previous' );
    }
}

function changeImage( action ) {
    var xmlhttp = new XMLHttpRequest(),
        url = "/change_tattoo/id_tattoo=" + id_tattoo_attribute + "&action=" + action + "&id_artist=" + id_artist_attribute;
    xmlhttp.open( "GET", url );

    xmlhttp.onload = function() {
        var response = JSON.parse( xmlhttp.response ),
            modalImg = document.getElementById( "img01" ),
            captionText = document.getElementById( "caption" );

        modalImg.src = "data:image/png;base64, " + response.image;
        captionText.innerHTML = response.txt;
        id_tattoo_attribute = response.id_tattoo;
    };

    xmlhttp.onprogress = function( event ) {
        if ( event.lengthComputable ) {
            console.log( `Received ${event.loaded} of ${event.total} bytes` );
        } else {
            console.log( `Received ${event.loaded} bytes` ); // no Content-Length
        }

    };

    xmlhttp.onerror = function() {
        console.log( "error" );
    };
    xmlhttp.send();
}
