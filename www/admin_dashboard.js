window.addEventListener('load', function(e){
    if(localStorage.getItem("mq==")){
        var local_session = localStorage.getItem("mq==");
        var data = "user_id="+atob(local_session);
        //console.log(data);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                console.log(xhr.responseText);
                var res = JSON.parse(xhr.responseText);
                if(res.success){

                    if(res.pass){
                        console.log(res.data);
                        console.log(res.data.id);
                        document.getElementById("user").innerHTML = "Hi "+res.data.name;
                        document.getElementById("user1").innerHTML = "Your Id is "+ res.data.id;
                        document.cookie = "user_id=" + res.data.id +";path=/;";
                    }else{
                        alert(res.message);
                    }
                }else{
                    alert('Something went wrong, kindly contact the admin');
                }
            }
        }
        xhr.open("POST","dashboard_user_record.php",true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(data);
    }else{
        alert("Your are not logged in");
        window.location = "admin_signin.html";

    }
})

//var panel = document.getElementsByClassName('panel');
//var array = ['Home', 'Transfer', 'Deposit', 'Account Statement', 'Log Out'];

//array.forEach(function(value){
//panel.insertAdjacentHTML("beforeend", "<ul>"+value+"</ul>");
//});

    

// array.forEach((value)=>{
//     service.insertAdjacentHTML("beforeend", "<ul>"+value+"</ul>");
//     });

//     var scroll = document.getElementById("name");
//     console.log(scroll);
// setTimeout((e) =>{
//     scroll.innerHTML = "Lungu Hills is a place of Comfort";
// }, 3000);
// setTimeout((e)=>{
//     scroll.innerHTML = "Loading";
//     //setInterval((e)=>{
//         //scroll.innerHTML = scroll.innerHTML + ".";
//     //}, 2000);
    
// }, 6000);

//function getCurrentUsersTodo(){

//}
//var html = "";
//res.data.foreach(function(value,key)){
//html + ="<h6>"+value.name+"</h6>";
//}