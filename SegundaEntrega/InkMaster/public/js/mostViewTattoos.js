var page = 2;

window.addEventListener( 'scroll', () => {
    var limit = document.documentElement.scrollHeight;
    if( window.scrollY + window.innerHeight >= limit ){
        loadImages();
    }

})

function loadImages( val = 6 ) {
    var container = document.getElementById( "container" );
    $.ajax(
        {
            type: "POST",
            url: "/get_tattoos",
            dataType: "html",
            data: {
                val: val,
                page: page
            },
        },
        page = page + 1,
    )
        .done( function( response ) {
            container.insertAdjacentHTML( 'beforeend', response );
            // page = page + 1;
        } )
        .fail( function() {
            console.log( "error" );
        } );
}