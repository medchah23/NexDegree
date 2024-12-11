document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", async function (event) {
        event.preventDefault(); // Prevent default form submission behavior

        if (validateLogin()) {
            const form = document.getElementById("loginForm");
            const formData = new FormData(form);

            try {
                const response = await fetch("../PHP/login.php", {
                    method: "POST",
                    body: formData,
                });

                const data = await response.json();
                if (response.ok && data.success) { // Corrected from result to data
                    createPopup(data.message, "success"); // Corrected from result to data
                    setTimeout(() => {
                        // Redirect to the user's dashboard
                        window.location.href = data.redirect_url; // Corrected from result to data
                    }, 2000);
                } else {
                    createPopup(data.message || "Une erreur s'est produite.", "error");
                }
            } catch (error) {
                console.error("Error:", error);
                createPopup("Erreur de communication avec le serveur.", "error");
            }
        }
    });

    // Frontend validation for email and password
    function validateLogin() {
        const email = document.getElementById("loginEmail");
        const password = document.getElementById("loginPassword");
        let isValid = true;

        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email.value)) {
            email.classList.add("error");
            createPopup("Invalid email address", "error");
            isValid = false;
        } else {
            email.classList.remove("error");
        }

        if (password.value.length < 8) {
            password.classList.add("error");
            createPopup("Password is too short (minimum 8 characters)", "error");
            isValid = false;
        } else {
            password.classList.remove("error");
        }

        return isValid;
    }

    // Function to display popups for validation feedback
    function createPopup(message, status) {
        const container = document.getElementById("popup-container");
        if (!container) return;

        const popup = document.createElement("div");
        popup.className = `popup ${status}`;
        popup.textContent = message;

        container.appendChild(popup);
        setTimeout(() => popup.classList.add("show"), 10);
        setTimeout(() => {
            popup.classList.remove("show");
            setTimeout(() => popup.remove(), 300);
        }, 3000);
    }
});