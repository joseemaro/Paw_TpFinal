
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

    var http = new XMLHttpRequest();
    var url = "/buscar_faq";
    var param = new FormData();
    param.append('val', values);
    http.open("POST", url, true);
    
    http.onreadystatechange = function (aEvt) {
        if(http.readyState == 4 && http.status == 200) {
            var node = document.getElementById( "content" );
            node.parentNode.removeChild( node );
            var target = document.getElementById("datos");
            target.innerHTML += http.responseText;
            accordion();
        }
    }
    http.onerror = function() {
        console.log( "error" );
    };
    http.send(param);
}

function increaseVisits( question, faq_id ){
    var req = new XMLHttpRequest();
    var s = "/increase_faq/" + faq_id
    req.open('GET', s, true);
    req.onreadystatechange = function (aEvt) {
    if (req.readyState == 4) {
        if(req.status == 200){
            var parentQuestion = question.parentElement,
            visits = parentQuestion.querySelector('.visits');
            visits.innerHTML = "Total de visitas: " + req.responseText;
        }
        }
    }
    req.onerror = function() {
        console.log( "error" );
    };
req.send(null);
}

