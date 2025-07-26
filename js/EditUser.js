
document.getElementById("editBtn").addEventListener("click", async function() {
    const fname = document.getElementById("fname").value;
    const lname = document.getElementById("lname").value;
    const email = document.getElementById("email").value;
    const userId = document.getElementById("user_id").value;
    const password = document.getElementById("password").value;
    
    const data = {
        firstName: fname,
        lastName: lname,
        email: email,
        password: password,
        id: userId
    };
    clearErrors();
    hasError = false;
    if (!data.firstName?.trim()) {
        document.getElementById("fNameError").textContent = "First name is required.";
        hasError = true;
    }
    if (!data.lastName?.trim()) {
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
    if (hasError) return;
        const response = await fetch("APIs/UsersAPI.php", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        // const result = await response.json();
        alert("Updated successfully!");
            
            window.location.href = "http://localhost/NTI/final_project/UserInfo.php";
        
    function clearErrors() {
        ["fName", "lName", "email", "password"].forEach(id => {
        document.getElementById(id + "Error").textContent = "";
    });
    }
  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
});

