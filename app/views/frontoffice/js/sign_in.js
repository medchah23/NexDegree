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
    document.getElementById("signupForm").addEventListener("submit", submitForm);
    document.getElementById("loginForm").addEventListener("submit", validatelogin);

    function toggleRole() {
        const role = document.getElementById("role").value;
        const student = document.getElementById("student");
        const prof = document.getElementById("prof");

        if (role === "etudient") {
            student.style.display = "block";
            prof.style.display = "none";
        } else if (role === "prof") {
            prof.style.display = "block";
            student.style.display = "none";
        } else {
            student.style.display = "none";
            prof.style.display = "none";
        }
    }

    function createPopup(message, status) {
        const popup = document.createElement("div");
        popup.classList.add("popup", status);
        popup.innerText = message;

        document.body.appendChild(popup);

        setTimeout(() => {
            popup.classList.add("show");
        }, 10);

        setTimeout(() => {
            popup.classList.remove("show");
            setTimeout(() => {
                popup.remove();
            }, 300);
        }, 3000);
    }

    function validateForm(event) {
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

        function removeShakeAnimation(element) {
            element.addEventListener("animationend", () => {
                element.classList.remove("error");
            });
        }

        if (!isStringValid(nom.value) || nom.value.trim() === "") {
            nom.value = "";
            nom.placeholder = "Prénom non valide";
            nom.classList.add("error");
            removeShakeAnimation(nom);
            isValid = false;
        }

        if (!isStringValid(prenom.value) || prenom.value.trim() === "") {
            prenom.value = "";
            prenom.placeholder = "Nom non valide";
            prenom.classList.add("error");
            removeShakeAnimation(prenom);
            isValid = false;
        }

        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email.value)) {
            email.value = "";
            email.placeholder = "Adresse email non valide";
            email.classList.add("error");
            removeShakeAnimation(email);
            isValid = false;
        }

        if (isNaN(tel.value) || tel.value.length !== 8) {
            tel.value = "";
            tel.placeholder = "Numéro de téléphone non valide";
            tel.classList.add("error");
            removeShakeAnimation(tel);
            isValid = false;
        }

        if (role.value === "") {
            role.classList.add("error");
            removeShakeAnimation(role);
            createPopup("Veuillez sélectionner un rôle", "error");
            isValid = false;
        }

        const lengthCriteria = password.value.length >= 8;
        const uppercaseCriteria = /[A-Z]/.test(password.value);
        const numberCriteria = /\d/.test(password.value);
        const specialCharCriteria = /[!@#$%^&*(),.?":{}|<>]/.test(password.value);

        if (!lengthCriteria || !uppercaseCriteria || !numberCriteria || !specialCharCriteria) {
            password.classList.add("error");
            removeShakeAnimation(password);
            createPopup("Votre mot de passe ne respecte pas les critères", "error");
            isValid = false;
        }

        if (password.value !== confirm.value) {
            confirm.classList.add("error");
            removeShakeAnimation(confirm);
            createPopup("Les mots de passe ne correspondent pas", "error");
            isValid = false;
        }

        return isValid;
    }

    async function submitForm(event) {
        event.preventDefault();
        const form = document.getElementById("signupForm");
        const formData = new FormData(form);
        const isValid = validateForm(event);
        if (!isValid) return;

        try {
            const response = await fetch("../PHP/sign_in.php", {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                throw new Error('Network response was not ok.');
            }

            const data = await response.json();

            if (data.success) {
                createPopup(data.message, 'success');
            } else {
                createPopup(data.message, 'error');
            }

        } catch (error) {
            console.error('Error:', error);
            createPopup("An error occurred while submitting the form.", 'error');
        }
    }

    async function validatelogin(event) {
        event.preventDefault();
        const email = document.getElementById("loginEmail");
        const password = document.getElementById("loginPassword");
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let isValid = true;

        if (!emailRegex.test(email.value)) {
            email.value = "";
            email.placeholder = "Adresse email non valide";
            email.classList.add("error");
            removeShakeAnimation(email);
            isValid = false;
        }

        const lengthCriteria = password.value.length >= 8;
        const uppercaseCriteria = /[A-Z]/.test(password.value);
        const numberCriteria = /\d/.test(password.value);
        const specialCharCriteria = /[!@#$%^&*(),.?":{}|<>]/.test(password.value);

        if (!lengthCriteria || !uppercaseCriteria || !numberCriteria || !specialCharCriteria) {
            password.classList.add("error");
            removeShakeAnimation(password);
            createPopup("Votre mot de passe ne respecte pas les critères", "error");
            isValid = false;
        }
    }

    function removeShakeAnimation(element) {
        element.addEventListener("animationend", () => {
            element.classList.remove("error");
        });
    }
});
