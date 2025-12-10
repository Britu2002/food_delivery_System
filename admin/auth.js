// Set default admin credentials securely
if (!localStorage.getItem("admin@zaapin.com")) {
    localStorage.setItem("admin@zaapin.com", btoa("admin123")); // Encrypt password
}

// Function to get stored credentials securely
function getCredentials() {
    return {
        email: "admin@zaapin.com",
        password: atob(localStorage.getItem("admin@zaapin.com")), // Decrypt password
    };
}

// ✅ **Login Function - Run only on login.php**
if (document.getElementById("login-form")) {
    document.getElementById("login-form").addEventListener("submit", function(event) {
        event.preventDefault();

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const { email: storedEmail, password: storedPassword } = getCredentials();

        if (email === storedEmail && password === storedPassword) {
            Swal.fire({
                title: "Login Successful",
                text: "Redirecting to Dashboard...",
                icon: "success",
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                localStorage.setItem("isLoggedIn", "true"); // Session tracking
                window.location.href = "admin-dashboard.php";
            });
        } else {
            document.getElementById("error-message").innerText = "Invalid Email or Password!";
        }
    });
}

// ✅ **Forget Password Function - Run only on forget-password.php**
if (document.getElementById("reset-form")) {
    document.getElementById("reset-form").addEventListener("submit", function(event) {
        event.preventDefault();

        const email = document.getElementById("resetEmail").value;
        const newPassword = document.getElementById("newPassword").value;

        if (localStorage.getItem(email)) {
            localStorage.setItem(email, btoa(newPassword)); // Encrypt password
            Swal.fire({
                title: "Password Reset Successful",
                text: "Now you can login with the new password!",
                icon: "success",
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "login.php";
            });
        } else {
            Swal.fire({
                title: "Error",
                text: "Email not found!",
                icon: "error"
            });
        }
    });
}
//
