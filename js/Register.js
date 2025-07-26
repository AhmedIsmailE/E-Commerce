document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registerForm");
  const errorBox = document.getElementById("errorBox");
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    const errors = [];

    clearErrors();
    hasError = false;
    if (!data.fName?.trim()) {
        document.getElementById("fNameError").textContent = "First name is required.";
        hasError = true;
    }
    if (!data.lName?.trim()) {
        document.getElementById("lNameError").textContent = "Last name is required.";
        hasError = true;
    }
    if (!isValidEmail(data.email)) {
        document.getElementById("emailError").textContent = "Invalid email format.";
        hasError = true;
    }
    if (!data.password || data.password.length < 6) {
        document.getElementById("passwordError").textContent = "Password must be at least 6 characters.";
        hasError = true;
    }
    if (data.password !== data.confirm_password) {
        document.getElementById("confirmPasswordError").textContent = "Passwords do not match.";
        hasError = true;
    }

    if (hasError) return;
  
    try {
      const response = await fetch("http://localhost/NTI/final_project/APIs/UsersAPI.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-Action": "register"
        },
        body: JSON.stringify(data)
      });

      const result = await response.json();

      if (response.ok) {
        window.location.href = "http://localhost/NTI/final_project/Login.php";
      } else {
        errorBox.innerHTML = result.errors.map(e => `<div>${e}</div>`).join('');
      }
    } catch (err) {
      errorBox.textContent = "Something went wrong. Please try again.";
    }
  });
  function clearErrors() {
        ["fName", "lName", "email", "password", "confirmPassword"].forEach(id => {
        document.getElementById(id + "Error").textContent = "";
    });
    }
  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
});
