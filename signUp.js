
// Funkcija za validaciju forme
function validateForm() {
    // Provjera jačine lozinke
    const password = document.getElementById('pass').value;
    const email = document.getElementById('email').value;
    
    const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;
    
    if (!passwordRegex.test(password)) {
        alert('Password must be at least 8 characters long, contain an uppercase letter, a lowercase letter, a number, and a special character.');
        return false;
    }

    // Provjera formata e-maila (HTML input type=email već osigurava osnovnu validaciju, ali možemo dodatno provjeriti)
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address.');
        return false;
    }

    return true; // Ako sve prođe, vraćamo true kako bi se forma poslala
}



    // Provjerava je li status jednak 'success'
    window.onload = function() {
        if (getQueryParam('status') === 'success') {
            alert("Profile successfully created!");
        }
    };

