function loadImage(element){
    console.log(element);
    document.getElementById("first_image").style.backgroundImage = "url("+element.src+")";
    //console.log(element.src);
}