document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  const emailError = document.getElementById("emailError");
  const passwordError = document.getElementById("passwordError");
  const generalError = document.getElementById("generalError");
  const login_Error = document.getElementById("login_Error");
  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();


    emailError.textContent = "";
    passwordError.textContent = "";
    generalError.textContent = "";
    login_Error.textContent = "";

    const data = {
      email: email.value.trim(),
      password: password.value.trim()
    };
  
    let hasError = false;

    if (!isValidEmail(data.email)) {
      emailError.textContent = "Enter a valid email.";
      hasError = true;
    }
    if (data.password.length < 6) {
      passwordError.textContent = "Password must be at least 6 characters.";
      hasError = true;
    }

    if (hasError) return;

    try {
      
      const response = await fetch("http://localhost/NTI/final_project/APIs/UsersAPI.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Action": "login"
        },
        
        body: JSON.stringify(data)
      });
     
      const result = await response.json();

      if (!response.ok) {
        
        if (result.message === "invalid email or password") {
            document.getElementById("login_Error").textContent = "Email or password is incorrect.";
        } else {
            document.getElementById("login_Error").textContent = "Something went wrong1. Please try again.";
        }
    } else {
        
        window.location.href = "http://localhost/NTI/final_project/Admin/AdminDashboard.php";
    }
    } catch (err) {
      generalError.textContent = "Something went wrong10. Please try again.";
    }
  });
});