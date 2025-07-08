var button = document.getElementById('login');

button.addEventListener('click', function(e){

var email = document.getElementById('email');
var hash = document.getElementById('hash');

if(email.value.length < 1 || hash.value.length < 1){
    alert("All things are required");
}else{
    var method = "POST";
    var url = "kreb_backend.php";
    var data = {
        "email": email.value,
        "hash": hash.value
    }
    var json = JSON.stringify(data);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            console.log(xhr.responseText);
           var res = JSON.parse(xhr.responseText);
            console.log(res);
            if(res.success){
                if(res.pass){
                     alert ("all is done");
                    console.log(btoa(res.user_id));
                    localStorage.setItem("user_id",btoa(res.user_id));
                    window.location = "dashboard.html";
                }else{
                alert(res.error);
                }
         }else{
            alert(res.failed);
        }
     }
}

    xhr.open(method,url,true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(json);
}
})