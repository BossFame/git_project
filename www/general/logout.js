document.addEventListener('click', function () {
        var logoutBtn = document.getElementById('logout');
        logoutBtn.addEventListener('click', function (e) {
                e.preventDefault(); // Stop the anchor from redirecting
                localStorage.removeItem('det');
                localStorage.removeItem('bal');
                localStorage.removeItem('ui');
                localStorage.clear();

                alert("You are now logged out");
                window.location.href = 'login.html';
            });
    });