window.addEventListener('load', function(e){
    if(localStorage.getItem('det')){
    session_data = JSON.parse(atob(localStorage.getItem('det')));
    var data = {
        "name": session_data.account_name,
        "number": session_data.account_number,
        "account": session_data.account_balance
    };


    document.getElementById('user').innerHTML = "Hi, " + data.name;
    document.getElementById('user1').innerHTML = "Account Number: " + data.number;
    document.getElementById('balance').innerHTML = "Account Balance: " + data.account;
    }
})

var button = document.getElementById('button');
button.addEventListener('click', function(e){
    var account = document.getElementById('account');
    var amount = document.getElementById('amount');

    if(account.value !== "", amount.value !==""){
        var data = {
            "account": account.value,
            "amount": amount.value,
            "email": atob(localStorage.getItem('ui'))
        }

        var json = JSON.stringify(data);
        // var data = " account= "+ account.value + " amount= " +amount.value + " email= "+ atob(localStorage.getItem('ui'));
        // console.log(data);
        

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
            console.log(xhr.responseText);
             var res = JSON.parse(xhr.responseText);
             if (res.pass) {
    alert(res.success);
            var newBalance = res.current_balance; 

            document.getElementById('balance').innerHTML = "Account Balance: " + newBalance;

            let sessionData = JSON.parse(atob(localStorage.getItem('det')));
            sessionData = {...sessionData, account_balance: newBalance };

            localStorage.setItem('det', btoa(JSON.stringify(sessionData)));


                }else{
                    alert(res.error);
            }

            }
        }

        xhr.open("POST","transfer.php",true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(json);
    }else{
        alert('All field is required');
    }

})