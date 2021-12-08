var page = 2;

window.addEventListener( 'scroll', () => {
    if( window.scrollY + window.innerHeight >= document.documentElement.scrollHeight ){
        loadImages();
    }
})

function loadImages( val = 6 ) {
    var container = document.getElementById( "container" );
    $.ajax( {
        type: "POST",
        url: "/public/ajax/loadImages.php",
        dataType: "html",
        data: {
            val: val,
            page: page
        },
    })
        .done( function( response ) {
            container.insertAdjacentHTML( 'beforeend', response );
            page = page + 1;
        } )
        .fail( function() {
            console.log( "error" );
        } );
}