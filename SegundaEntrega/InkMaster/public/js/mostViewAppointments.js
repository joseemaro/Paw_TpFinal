var page = 2;

window.addEventListener( 'scroll', () => {
    var limit = document.documentElement.scrollHeight;
    if( window.scrollY + window.innerHeight >= limit ){
        var list_appointment_container = document.getElementsByClassName( "container-section" )[0];

        var preload = document.createElement("img");
        preload.src = "/public/images/Spinner.svg";
        preload.id = "preload_list_appointment";
        preload.className = "preload-spinner";

        list_appointment_container.appendChild( preload );
        loadImages();
    }

})

function loadImages( val = 6 ) {
    var tbody = document.getElementsByClassName( "table-content" )[0],
        xmlhttp = new XMLHttpRequest(),
        url = "/get_appointments/page=" + page;
    xmlhttp.open( "GET", url );

    xmlhttp.onload = function() {
        var response = JSON.parse( xmlhttp.response );

        for (var i = 0; i < Object.keys( response ).length; i++) {

            var NewTr = document.createElement("tr");
            NewTr.setAttribute( "data-appointment-id", response[i].id_appointment );

            var TdIDArtist = document.createElement("td");
            TdIDArtist.textContent = response[i].id_artist;
            NewTr.appendChild( TdIDArtist );
            var TdIDLocal = document.createElement("td");
            TdIDLocal.textContent = response[i].id_local;
            NewTr.appendChild( TdIDLocal );
            var TdDate = document.createElement("td");
            TdDate.textContent = response[i].date;
            NewTr.appendChild( TdDate );
            var TdHour = document.createElement("td");
            TdHour.textContent = response[i].hour;
            NewTr.appendChild( TdHour );
            var TdIDUser = document.createElement("td");
            TdIDUser.textContent = response[i].id_user;
            NewTr.appendChild( TdIDUser );
            var TdPhone = document.createElement("td");
            TdPhone.textContent = response[i].phone;
            NewTr.appendChild( TdPhone );
            var TdEmail = document.createElement("td");
            TdEmail.textContent = response[i].email;
            NewTr.appendChild( TdEmail );
            var TdStatus = document.createElement("td");
            TdStatus.textContent = response[i].status;
            NewTr.appendChild( TdStatus );
            var TdPrice = document.createElement("td");
            if ( response[i].price == null ) {
                TdPrice.textContent = "-";
            } else {
                TdPrice.textContent = response[i].price;
            }
            NewTr.appendChild( TdPrice );
            var TdActions = document.createElement("td");
            NewTr.appendChild( TdActions );

            tbody.appendChild( NewTr );
        }
        var preloadImg = document.getElementById( "preload_list_appointment" );
        preloadImg.parentElement.removeChild( preloadImg );
    };

    xmlhttp.onprogress = function( event ) {
        if ( event.lengthComputable ) {
            console.log( `Received ${event.loaded} of ${event.total} bytes` );
        } else {
            console.log( `Received ${event.loaded} bytes` ); // no Content-Length
        }

    };

    xmlhttp.onerror = function() {
        var preloadImg = document.getElementById( "preload_list_appointment" );
        preloadImg.parentElement.removeChild( preloadImg );
        console.log( "error" );
    };
    xmlhttp.send();
    page = page + 1;
}