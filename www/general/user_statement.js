window.addEventListener('load', function(e) {
    if (localStorage.getItem('det')) {
        var local_session = JSON.parse(atob(localStorage.getItem('det')));

        var data = {
            "name": local_session.account_name,
            "number": local_session.account_number,
            "bal": local_session.account_balance
        };

            var json = JSON.stringify(data);
        
        document.getElementById('balance').innerHTML = "Account Balance: " + data.bal;
        document.getElementById('user').innerHTML = "Hi, " + data.name;
        document.getElementById('user1').innerHTML = "Account Number: " + data.number;

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var res = JSON.parse(xhr.responseText);
                     document.getElementById('balance').innerHTML = "Account Balance: " + res.acc;
                if (res.pass) {
                    var bodys = document.querySelector("#details");
                    bodys.innerHTML = "";
                    res.details.forEach(function(value) {
                        var tr = document.createElement("tr");
                        tr.innerHTML = `<td>${value.date_created}</td>
                                        <td>${value.time_created}</td>
                                        <td>${value.receivers_account}</td>
                                        <td>${value.transaction_type}</td>
                                        <td>${value.transaction_amount}</td>
                                        <td>${value.previous_balance}</td>
                                        <td>${value.final_balance}</td>`;
                        bodys.appendChild(tr);
                    });
                } else {
                    alert(res.error);
                }
            }
        };

        xhr.open('POST','user_statement.php', true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(json);
    }else{
        alert("You're not logged in");
        window.location = "login.html";
    }
});
