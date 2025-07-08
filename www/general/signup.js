var signup = document.getElementById("create");

signup.addEventListener('click', function(e){

    var fullname = document.getElementById('fullname');
    var email = document.getElementById('email');
    var hash = document.getElementById('hash');
    var confirm_hash = document.getElementById('confirm_hash');

    if(fullname.value.length < 1 || email.value.length < 1 || hash.value.length < 1 || confirm_hash.value.length < 1){
        alert("Input required values")
    }else if(confirm_hash.value !== hash.value){
           alert("Password Mismatch");
    }else{
        var data = {
        "fullname": fullname.value,
        "email": email.value,
        "hash": hash.value
    }
    var json = JSON.stringify (data);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            console.log(xhr.responseText);
            var res = JSON.parse(xhr.responseText);
            if(res.email_exist){
                alert(res.error);
            }else if(res.success){
                alert(res.message);
                window.location = "login.html";
            }else{
                alert(res.failed);
            }
        }
    }

    xhr.open("POST","signup.php",true);
    xhr.onreadystatechange("Content-Type", "application/json");
    xhr.send(json);

    
    
    }

})