
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
        })
        .fail(function(){
            console.log("error");
        });
    }

