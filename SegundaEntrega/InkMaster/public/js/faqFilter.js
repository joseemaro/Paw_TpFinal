
this.addEventListener("DOMContentLoaded", () =>{
    accordion();
})

function accordion() {
    const questions = document.querySelectorAll(".question")
    questions.forEach((question) => question.addEventListener("click", () =>{
        if(question.parentNode.classList.contains("active")){
            question.parentNode.classList.toggle("active")
        } else{
            questions.forEach(question => question.parentNode.classList.remove("active"))
            question.parentNode.classList.add("active")
            var faq_id = question.getAttribute( "data-faq-id" );
            increaseVisits( question, faq_id )
        }
    }))
}

function getFaqs( values ){

    console.log(values);
    var xmlhttp = new XMLHttpRequest(),
        url = "/buscar_faq/val=" + values;
    xmlhttp.open("GET", url );

    xmlhttp.onload = function (aEvt) {
        var node = document.getElementById( "content" );
        node.parentNode.removeChild( node );
        var target = document.getElementById("datos");
        target.innerHTML += xmlhttp.response;
        accordion();
    }

    xmlhttp.onprogress = function( event ) {
        if ( event.lengthComputable ) {
            console.log( `Received ${event.loaded} of ${event.total} bytes` );
        } else {
            console.log( `Received ${event.loaded} bytes` );
        }
    };

    xmlhttp.onerror = function() {
        console.log( "error" );
    };
    xmlhttp.send();
}

function increaseVisits( question, faq_id ){
    var xmlhttp = new XMLHttpRequest();
    var s = "/increase_faq/" + faq_id
    xmlhttp.open('GET', s, true);

    xmlhttp.onload = function (aEvt) {
        var parentQuestion = question.parentElement,
            visits = parentQuestion.querySelector('.visits');
        visits.innerHTML = "Total de visitas: " + xmlhttp.responseText;
    }

    xmlhttp.onerror = function() {
        console.log( "error" );
    };
    xmlhttp.send();
}

