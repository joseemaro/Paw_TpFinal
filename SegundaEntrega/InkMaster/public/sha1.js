function cifrar(){
    var input_pass = document.getElementById("password");
    input_pass.value = sha1(input_pass.value);
}