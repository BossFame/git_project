var button = document.getElementById("login");
button.addEventListener("click", function(e){ 
    var email =  document.getElementById("email");
    var password = document.getElementById("password");
   
    if(email.value !== "" || password.value !== ""){
        alert("Welcome");
    }else{
        alert("Enter necessary information");
    }})