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
        var response = xmlhttp.response;
        container.insertAdjacentHTML( 'beforeend', response );
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