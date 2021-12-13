function accordion() {
    const questions = document.querySelectorAll(".question")
    questions.forEach((question) => question.addEventListener("click", () =>{
        if(question.parentNode.classList.contains("active")){
            question.parentNode.classList.toggle("active")
        }
    else{
        questions.forEach(question => question.parentNode.classList.remove("active"))
        question.parentNode.classList.add("active")
    }
    }))
}

function getFaqs(val){
        $.ajax({
            type: "POST",
            url: "/public/ajax/buscarFaq.php",
            dataType: "html",
            data: {val: val},
        })
        .done(function(respuesta){
            var node = document.getElementById("content");
            node.parentNode.removeChild(node);
            $("#datos").html(respuesta);
            accordion();
        })
        .fail(function(){
            console.log("error");
        });
    }

this.addEventListener("DOMContentLoaded", () =>{
    accordion();
})

