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

function getFaqs( val ){
    $.ajax(
        {
            type: "POST",
            url: "/buscar_faq",
            dataType: "html",
            data: {val: val},
        }
    )
        .done( function( response ) {
            var node = document.getElementById( "content" );
            node.parentNode.removeChild( node );
            $( "#datos" ).html( response );
            accordion();
        } )
        .fail( function() {
            console.log("error");
        } );
}

function increaseVisits( question, faq_id ){
    $.ajax({
        type: "GET",
        url: "/increase_faq/" + faq_id,
        dataType: "text"
    })
    .done(function( respuesta ){
        var parentQuestion = question.parentElement,
            visits = parentQuestion.querySelector('.visits');
        visits.innerHTML = "Total de visitas: " + respuesta;
    })
    .fail(function(){
        console.log("error");
    });
}

this.addEventListener("DOMContentLoaded", () =>{
    accordion();
})
