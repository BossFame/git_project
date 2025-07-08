window.addEventListener('load',function(e){
    // var local_session = localStorage.getItem("user_id");
    // console.log(atob(local_session));
    if(localStorage.getItem('user_id')){
        var local_session = localStorage.getItem("user_id");

        var data = "user_id="+atob(local_session);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log(xhr.responseText);
                var res = JSON.parse(xhr.responseText);
                if(res.message){
                    if(res.success){
                        //alert("Good Luck");
                        document.getElementById("intro").innerHTML = "Dear "+res.data.name+", welcome to Lungu Hills.";
                        document.getElementById("identity").innerHTML = "Your Id is:" +res.data.id;
                       getTodo();
                    }else{
                        alert(res.error);
                    }

                }else{
                    alert(res.failed);
                }
            }
        }
        xhr.open("POST","dashboardBackend",true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(data);

    }else{
        alert("You are not logged in");
        window.location = "kreb_login.html";
    }
})



var button = document.getElementById("btn");
button.addEventListener("click", function(e){
    var title =  document.getElementById("title");
    var date = document.getElementById("date");
    var time = document.getElementById("time")
   

    if(title.value !=="", date.value !=="", time.value !==""){
        //alert("All will be fine");
        var data = {"title": title.value,
            "date": date.value,
            "time": time.value,
            "user_id": atob(localStorage.getItem("user_id"))
        }
        var json = JSON.stringify(data);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log(xhr.responseText);
                var res = JSON.parse(xhr.responseText);
                if(res.success){
                        //alert("Successful")
                        getTodo();
                }else{
                    alert(res.failed);
                }
            }
        }
        xhr.open("POST","backend/todo.php",true);
        xhr.setRequestHeader("Content_Type", "application/json");
        xhr.send(json);
    }else{
        alert("All fields are required");
    }
})

function getTodo(){
    var data = "user_id="+atob(localStorage.getItem("user_id"));

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            //console.log(xhr.responseText);
            var res = JSON.parse(xhr.responseText);
            console.log(res);
            if(res.message){
                var html = "";
                res.data.forEach(function(value, key){
                    html += "<h4>" + value.name +" || "+  value.date +" || "+ value.time +"<h4>"
                });
                document.getElementById('prog').innerHTML = html;
                alert("You Input has been added successfully");
                
            }else{
                alert(res.failed);
            }

        }
    }


    xhr.open("POST","userTodo.php",true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);
}