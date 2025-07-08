var register = document.getElementById("submit");

register.addEventListener("click", function(e){

var name = document.getElementById("name");
var email = document.getElementById("email");
var hash = document.getElementById("hash");
var confirm_hash = document.getElementById("confirm_hash");

if(name.value!=="" && email.value !=="" && hash.value !=="" && confirm_hash !==""){
    if(confirm_hash.value == hash.value){
   // alert("Information inputed succesfully");
   var method = "POST";
   var url = "backend/kreb_backend.php";
   var data = {
    "name": name.value,
    "email": email.value,
    "hash": hash.value
   };
     //data = "fullname="+fullname.value;

   var json = JSON.stringify(data);
   var xhr = new XMLHttpRequest();
   xhr.onreadystatechange = function(){
    if(xhr.readyState == 4 && xhr.status == 200){
       //console.log(xhr.responseText);
       alert('registration completed');
       var res = JSON.parse(xhr.responseText);
       console.log(res);
       if(res.success){
        window.location = "kreb_login.html";
        alert("Your login was successful, You can now proceed to login");
       }else{
        alert("Something went wrong, you can contact the Admin for further clarification");
       }


    }
   }
   
   xhr.open(method,url,true);
   xhr.setRequestHeader("Content-Type", "application/json");
   xhr.send(json);

    }else{
        alert("Password Mismatch");
    }
}else{
    alert("All fields are required");
}
}, false);