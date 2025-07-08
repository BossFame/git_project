var button = document.getElementById("login");

button.addEventListener('click', function(e){
    var email = document.getElementById("email");
    var hash = document.getElementById("password");

    if(email.value !=="" || hash.value !=="" ){
        //alert("Welcome Back");
        var data = {"email": email.value, "hash": hash.value}
        console.log(data);

        var json = JSON.stringify(data);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log(xhr.responseText);
                var res = JSON.parse(xhr.responseText);
                console.log(res);
                if(res.success){
                    if(res.pass){
                        alert("Login was succesful");
                        console.log(btoa(res.user_id));
                        localStorage.setItem("mq==",btoa(res.user_id));
                        window.location = "admin_dashboard.html";
                    }else{
                        alert(res.error);
                    }
                }else{
                    alert(res.failed);
                }
            }
        }

        xhr.open("POST","admin_signin.php",true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(json);
        

    }else{
        alert("Enter Necessary info");
    }
})