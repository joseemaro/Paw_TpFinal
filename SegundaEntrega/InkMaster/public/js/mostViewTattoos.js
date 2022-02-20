var page = 2;

window.addEventListener( 'scroll', () => {
    var limit = document.documentElement.scrollHeight;
    if( window.scrollY + window.innerHeight >= limit ){
        loadImages();
    }

})

function loadImages( val = 6 ) {
    var container = document.getElementById( "container" ),
        xmlhttp = new XMLHttpRequest(),
        url = "/get_tattoos/page=" + page;
    xmlhttp.open( "GET", url );

    xmlhttp.onload = function() {
        var response = JSON.parse( xmlhttp.response );

        for (var i = 0; i < Object.keys( response ).length; i++) {

            var newImg = document.createElement("img");
            newImg.className = "myImg";
            newImg.src = "data:image/png;base64, " + response[i].image;
            newImg.alt = response[i].txt;
            newImg.setAttribute( "data-tattoo-id", response[i].id_tattoo );

            container.appendChild( newImg );
        }
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
    page = page + 1;
}