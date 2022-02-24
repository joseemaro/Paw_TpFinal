var page = 2;

document.addEventListener("DOMContentLoaded", () =>{
    var mediaqueryList = window.matchMedia("(min-width: 1024px)");
    if( mediaqueryList.matches ) {
        var list_appointment_container = document.getElementsByClassName( "container-section" )[0];

        var preload = document.createElement("img");
        preload.src = "/public/images/Spinner.svg";
        preload.id = "preload_list_appointment";
        preload.className = "preload-spinner";

        list_appointment_container.appendChild( preload );
        loadImages();
    }
})

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
        var response = JSON.parse( xmlhttp.response ),
            appointments = response.appointments,
            isArtist = response.isArtist;
        console.log( response );

        for (var i = 0; i < Object.keys( appointments ).length; i++) {

            var NewTr = document.createElement("tr");
            NewTr.setAttribute( "data-appointment-id", appointments[i].id_appointment );

            var TdIDArtist = document.createElement("td");
            TdIDArtist.textContent = appointments[i].id_artist;
            NewTr.appendChild( TdIDArtist );
            var TdIDLocal = document.createElement("td");
            TdIDLocal.textContent = appointments[i].id_local;
            NewTr.appendChild( TdIDLocal );
            var TdDate = document.createElement("td");
            TdDate.textContent = appointments[i].date;
            NewTr.appendChild( TdDate );
            var TdHour = document.createElement("td");
            TdHour.textContent = appointments[i].hour;
            NewTr.appendChild( TdHour );
            var TdIDUser = document.createElement("td");
            TdIDUser.textContent = appointments[i].id_user;
            NewTr.appendChild( TdIDUser );
            var TdPhone = document.createElement("td");
            TdPhone.textContent = appointments[i].phone;
            NewTr.appendChild( TdPhone );
            var TdEmail = document.createElement("td");
            TdEmail.textContent = appointments[i].email;
            NewTr.appendChild( TdEmail );
            var TdStatus = document.createElement("td");
            TdStatus.textContent = appointments[i].status;
            NewTr.appendChild( TdStatus );
            var TdPrice = document.createElement("td");
            if ( appointments[i].price == null ) {
                TdPrice.textContent = "-";
            } else {
                TdPrice.textContent = appointments[i].price;
            }
            NewTr.appendChild( TdPrice );
            var TdActions = document.createElement("td");
            if ( isArtist && appointments[i].status === 'pending' ) {
                var actionAccept = document.createElement("a");
                actionAccept.href = "/acept_appointment/" + appointments[i].id_appointment;
                actionAccept.className = "link accept-btn";
                actionAccept.id = "acept-appointment-" + appointments[i].id_appointment;
                actionAccept.textContent = "Aceptar"
                TdActions.appendChild( actionAccept );
            }
            var actionView = document.createElement("a");
            actionView.href = "/view_appointment/" + appointments[i].id_appointment;
            actionView.className = "link view-btn";
            actionView.id = "show-appointment-" + appointments[i].id_appointment;
            actionView.textContent = "Ver"
            TdActions.appendChild( actionView );
            if ( isArtist && appointments[i].status === 'pending' ) {
                var actionEdit = document.createElement("a");
                actionEdit.href = "/edit_appointment/" + appointments[i].id_appointment;
                actionEdit.className = "link edit-btn";
                actionEdit.id = "edit-appointment-" + appointments[i].id_appointment;
                actionEdit.textContent = "Editar"
                TdActions.appendChild( actionEdit );

                var actionDetroy = document.createElement("a");
                actionDetroy.href = "/del_appointment/" + appointments[i].id_appointment;
                actionDetroy.className = "link cancel-btn";
                actionDetroy.id = "destroy-appointment-" + appointments[i].id_appointment;
                actionDetroy.textContent = "Cancelar"
                TdActions.appendChild( actionDetroy );
            }

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