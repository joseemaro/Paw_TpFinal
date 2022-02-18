
this.addEventListener("DOMContentLoaded", () =>{
    accordion();
})

function accordion() {
    const questions = document.querySelectorAll(".question")
    questions.forEach((question) => question.addEventListener("click", () =>{
        if(question.parentElement.classList.contains("active")){
            question.parentElement.classList.toggle("active")
        } else{
            questions.forEach(question => question.parentElement.classList.remove("active"))
            question.parentElement.classList.add("active")
            var faq_id = question.parentElement.getAttribute( "data-faq-id" );
            increaseVisits( question, faq_id )
        }
    }))
}

function getFaqs( values ){
    var xmlhttp = new XMLHttpRequest(),
        url = "/buscar_faq/val=" + values;
    xmlhttp.open("GET", url );

    xmlhttp.onload = function (aEvt) {
        var response = JSON.parse( xmlhttp.response );
        var faqs_response = response.faqs;
        var newDiv = document.createElement("div");
        newDiv.className = "questions__accordions";
        var newNode = document.createElement("div");
        newNode.className = "questions__accordions";
        newNode.id = "content";
        var node = document.getElementById( "content" );
        var accordion_wrapper = node.parentElement;

        for (var i = 1; i <= Object.keys( faqs_response ).length; i++) {
            var question = node.getElementsByClassName("question-answer__accordion");
            for (var j = 0; j < question.length; j++) {
                var faq_id = question[j].getAttribute("data-faq-id");
                if ( faqs_response[i] === faq_id ) {
                    newDiv.appendChild(question[j]);
                }
            }
        }

        node.parentNode.removeChild( node );
        newNode.appendChild(newDiv);
        accordion_wrapper.appendChild(newNode);
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

