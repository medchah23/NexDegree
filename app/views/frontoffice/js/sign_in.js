document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.querySelector(".wrapper");
    const signupHeader = document.querySelector(".form.signup header");
    const loginHeader = document.querySelector(".form.login header");

    loginHeader.addEventListener("click", () => {
        wrapper.classList.add("active");
    });

    signupHeader.addEventListener("click", () => {
        wrapper.classList.remove("active");
    });

    document.getElementById("role").addEventListener("change", toggleRole);

    document.getElementById("signupForm").addEventListener("submit", async function (event) {
        event.preventDefault();
        if (validateForm()) {
            await submitForm(event);
        }
    });



    function toggleRole() {
        const role = document.getElementById("role").value;
        const student = document.getElementById("student");
        const prof = document.getElementById("prof");

        if (role === "etudiant") {
            student.style.display = "block";
            prof.style.display = "none";
        } else if (role === "enseignant") {
            prof.style.display = "block";
            student.style.display = "none";
        } else {
            student.style.display = "none";
            prof.style.display = "none";
        }
    }

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

    function validateForm() {
        const nom = document.getElementById("firstName");
        const prenom = document.getElementById("secondName");
        const email = document.getElementById("email");
        const tel = document.getElementById("phoneNumber");
        const role = document.getElementById("role");
        const password = document.getElementById("password");
        const confirm = document.getElementById("cpassword");
        let isValid = true;

        function isStringValid(ch) {
            return /^[A-Za-z]+$/.test(ch);
        }

        if (!isStringValid(nom.value) || nom.value.trim() === "") {
            nom.classList.add("error");
            createPopup("Prénom non valide", "error");
            isValid = false;
        }

        if (!isStringValid(prenom.value) || prenom.value.trim() === "") {
            prenom.classList.add("error");
            createPopup("Nom non valide", "error");
            isValid = false;
        }

        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email.value)) {
            email.classList.add("error");
            createPopup("Adresse email non valide", "error");
            isValid = false;
        }

        if (isNaN(tel.value) || tel.value.length !== 8) {
            tel.classList.add("error");
            createPopup("Numéro de téléphone non valide", "error");
            isValid = false;
        }

        if (role.value === "") {
            createPopup("Veuillez sélectionner un rôle", "error");
            isValid = false;
        }

        const lengthCriteria = password.value.length >= 8;
        const uppercaseCriteria = /[A-Z]/.test(password.value);
        const numberCriteria = /\d/.test(password.value);
        const specialCharCriteria = /[!@#$%^&*(),.?":{}|<>]/.test(password.value);

        if (!lengthCriteria || !uppercaseCriteria || !numberCriteria || !specialCharCriteria) {
            password.classList.add("error");
            createPopup("Votre mot de passe ne respecte pas les critères", "error");
            isValid = false;
        }

        if (password.value !== confirm.value) {
            confirm.classList.add("error");
            createPopup("Les mots de passe ne correspondent pas", "error");
            isValid = false;
        }

        return isValid;
    }



    async function submitForm(event) {
        const form = document.getElementById("signupForm");
        const formData = new FormData(form);

        try {
            const response = await fetch("../PHP/sign_in.php", {
                method: "POST",
                body: formData,
            });

            const data = await response.json();
            if (response.ok && data.success) {
                createPopup(data.message || "Inscription réussie !", "success");
            } else {
                createPopup(data.message || "Une erreur s'est produite.", "error");
            }
        } catch (error) {
            console.error("Error:", error);
            createPopup("Erreur de communication avec le serveur.", "error");
        }
    }
});
