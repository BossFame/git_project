function loadImage(element){
    //console.log(element);
    var target = document.getElementById("first-image")
    target.style.opacity = 0;
    setTimeout((e) => {
        target.style.backgroundImage = "url(" + element.src + ")";
        target.style.opacity = 1;
    }, 500);
}

window.addEventListener('load', function(e){
    if(localStorage.getItem('ui')){
    var local_session = localStorage.getItem('ui');

    var data = "email=" + encodeURIComponent(atob(local_session));
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            console.log(xhr.responseText);
            var res = JSON.parse(xhr.responseText);
            if(res.success){
                if(res.pass){
                    document.getElementById('user').innerHTML = "Hi, "+res.account_name;
                    document.getElementById('user1').innerHTML = "Account Number: "+res.account_number;
                    document.getElementById('balance').innerHTML = "Account Balance: "+res.account_balance;
                    localStorage.setItem("det",btoa(JSON.stringify(res)));
                }else{
                    alert(res.error);
                }
            }else{
                alert(res.failed);
            }
            
        }
        
    };

    xhr.open("POST","dashboard.php",true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);


    }else{
        alert("You are not logged in");
        window.location = "login.html";

    }
});