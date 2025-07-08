var dashboard = document.getElementById('dash');
var signup = document.getElementById('signup');
setTimeout((e)=>{
    dashboard.style.color = 'green';
}, 3000);
setTimeout((e)=>{
    signup.style.backgroundColor = 'White';
}, 3000);
var dot = setInterval((e)=>{
    dashboard.innerHTML= dashboard.innerHTML + ".";
}, 4000);
setTimeout(function(e){
    clearInterval(dot);
}, 12000)
setTimeout(function(e){
    dashboard.innerHTML = "Access your Banking Dashboard";
}, 12000);
setTimeout(function(e){
    dashboard.innerHTML = " ";
}, 19000)
setTimeout(function(e){
    dashboard.innerHTML = "Access your Banking Dashboard"
}, 19000)
setTimeout((e)=>{
    signup.style.backgroundColor = 'Green';
}, 19000)
setTimeout((e)=>{
    dashboard.style.color = "White";
}, 20000)
setTimeout((e)=>{
    dashboard.classList.add('scroll-text');
}, 20000);

var button = document.getElementById('continue');
button.addEventListener('click', (e)=>{
    var email = document.getElementById('email');
    var hash = document.getElementById('hash');
    
    if(email.value !== "" && hash.value !=="" ){
        var data = ({
            "email": email.value,
            "hash": hash.value
        })

        var json = JSON.stringify(data);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                //console.log(xhr.responseText);
                var res = JSON.parse(xhr.responseText);
                if(res.success){
                    if(res.pass){
                        console.log(btoa(res.email));
                        localStorage.setItem("ui", btoa(res.email));
                        window.location ="dashboard.html";
                        alert("Your Login was succesful");


                    }else{
                        alert(res.error);
                    }
                }else{
                    alert(res.failed);
                }
            }
        }

    xhr.open("POST","login.php",true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.send(json);

    }else{
        alert("Input all fields");
    }
})