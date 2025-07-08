var scroll = document.getElementById("name");
    console.log(scroll);
setTimeout((e) =>{
    scroll.innerHTML = "Lungu Hills is a place of Comfort";
}, 3000);
setTimeout((e)=>{
    scroll.innerHTML = "Loading";
    //setInterval((e)=>{
        //scroll.innerHTML = scroll.innerHTML + ".";
    //}, 2000);
    
}, 6000);
setTimeout((e)=>{    
    scroll.innerHTML = "Lungu Hill, Your place of Comfort";
}, 12000);
setTimeout(function(e){
    scroll.style.color = "black";
}, 2000);
setTimeout((e) =>{
    scroll.style.color = "white";
}, 3000);

var service = document.getElementById("service");

var array = ['Hotel', 'Restaurant', 'Event', 'Banking', 'Blog'];

// array.forEach((value, key)=>{
//     service.innerHTML = value;
// });

array.forEach((value)=>{
    service.insertAdjacentHTML("beforeend", "<ul>"+value+"</ul>");
    });


//service.addEventListener('click',(e)=>{
    //service.style.color = "Orange";
//});

var takeAction = ((e)=>{
    service.style.color = "gold";
});
service.addEventListener('click', takeAction);

var x;
for(x=0; x<10; x++){
    console.log(x);
};

console.log(array.length);

var y;
for( y=0; y < array.length; y++){
    console.log(array[y]);
};

var worship = {"Church": "Anglican", "Mosque": "Ansar udeen"};
for(x in worship){
    console.log(worship[x]);
};
if(worship.Church){
    console.log(worship.Church);
}else{
    console.log("It Doesn't Exist");
}
var button = document.getElementById("btn");
var clone = document.getElementById("clone");
var repeat = document.getElementById("repeat");

button.addEventListener('click', function(e){
    var input_val = clone.value;

    repeat.insertAdjacentHTML("beforeend", "<p>"+ input_val +"</p>");
    clone.value = "";

})

var second_clone = document.getElementById("second_clone");

second_clone.addEventListener("input", function(e){
    repeat.innerHTML = second_clone.value;
})

// var method= "GET";
// var url = "backend.php?name=Akole Banji";

// var xhttp = new XMLHttpRequest();

// xhttp.onreadyStatechange = function(){
//     if(xhttp.readyState == 4 && xhttp.status == "200"){
//         console.log(xhttp.responseText);

//     }
// }
// xhttp.open(method,url,true);
// xhttp.send();

//SECOND METHOD FETCHING FROM THE BACKEND

var butt = document.getElementById('butt');
butt.addEventListener('click', function(e){
    var method= "POST";
    var url = "backend.php";
    var param = "name="+document.getElementById("name").value;

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function(){
        if(xhttp.readyState == 4 && xhttp.status == "200"){
           //alert(xhttp.responseText);
           document.getElementById("response").innerHTML = "<p style='color:white'>" +xhttp.responseText+ "</p>";
        }
    };

    xhttp.open(method,url,true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(param);
   // alert("Button Clicked");

 },false);