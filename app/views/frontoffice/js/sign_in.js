const wrapper = document.querySelector(".wrapper");
const signupHeader = document.querySelector(".form.signup header");
const loginHeader = document.querySelector(".form.login header");
loginHeader.addEventListener("click", () => {
    wrapper.classList.add("active");
});
signupHeader.addEventListener("click", () => {
    wrapper.classList.remove("active");
});
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
function createPopupWithCallback(message, status, callback = null) {
    const existingPopup = document.querySelector(".popup");
    if (existingPopup) {
        existingPopup.remove();
    }

    const popup = document.createElement("div");
    popup.classList.add("popup", status);

    const messageElement = document.createElement("div");
    messageElement.innerText = message;
    popup.appendChild(messageElement);

    if (callback) {
        const buttonContainer = document.createElement("div");
        buttonContainer.classList.add("button-container");

        const confirmButton = document.createElement("button");
        confirmButton.classList.add("confirm-button");
        confirmButton.innerText = "Confirmer";
        confirmButton.onclick = () => {
            callback(true);
            popup.remove();
        };

        const cancelButton = document.createElement("button");
        cancelButton.classList.add("cancel-button");
        cancelButton.innerText = "Annuler";
        cancelButton.onclick = () => {
            callback(false);
            popup.remove();
        };

        buttonContainer.appendChild(confirmButton);
        buttonContainer.appendChild(cancelButton);
        popup.appendChild(buttonContainer);
    }

    document.body.appendChild(popup);

    setTimeout(() => {
        popup.classList.add("show");
    }, 10);

    if (!callback) {
        setTimeout(() => {
            popup.classList.remove("show");
            setTimeout(() => {
                popup.remove();
            }, 300);
        }, 3000);
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
function isStringValid(ch) {
    return /^[A-Za-z]+$/.test(ch);
}
function removeShakeAnimation(element) {
    element.addEventListener("animationend", () => {
        element.classList.remove("error");
    });
}
function validateForm(event) {
    event.preventDefault();

    const nom = document.getElementById("firstName");
    const prenom = document.getElementById("secondName");
    const email = document.getElementById("email");
    const tel = document.getElementById("phoneNumber");
    const role = document.getElementById("role");
    const password = document.getElementById("password");
    const confirm = document.getElementById("cpassword");
    const passwordCriteria = document.getElementById("passwordCriteria");
    let isValid = true;

    // Validation du prénom
    if (!isStringValid(nom.value) || nom.value.trim() === "") {
        nom.value = "";
        nom.placeholder = "Prénom non valide";
        nom.classList.add("error");
        removeShakeAnimation(nom);
        isValid = false;
    }

    // Validation du nom
    if (!isStringValid(prenom.value) || prenom.value.trim() === "") {
        prenom.value = "";
        prenom.placeholder = "Nom non valide";
        prenom.classList.add("error");
        removeShakeAnimation(prenom);
        isValid = false;
    }

    // Validation de l'email
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(email.value)) {
        email.value = "";
        email.placeholder = "Adresse email non valide";
        email.classList.add("error");
        removeShakeAnimation(email);
        isValid = false;
    }

    // Validation du numéro de téléphone
    if (isNaN(tel.value) || tel.value.length !== 8) {
        tel.value = "";
        tel.placeholder = "Numéro de téléphone non valide";
        tel.classList.add("error");
        removeShakeAnimation(tel);
        isValid = false;
    }

    // Validation du rôle
    if (role.value === "") {
        role.classList.add("error");
        removeShakeAnimation(role);
        createPopup("Veuillez sélectionner un rôle", "error");
        isValid = false;
    }

    // Validation des critères du mot de passe
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

    // Confirmation du mot de passe
    if (password.value !== confirm.value) {
        confirm.classList.add("error");
        removeShakeAnimation(confirm);
        createPopup("Les mots de passe ne correspondent pas", "error");
        isValid = false;
    }

    // Si tout est valide, soumettre le formulaire
    if (isValid) {
        createPopup("Formulaire soumis avec succès !", "success");
        document.getElementById("signupForm").submit();
    }
}
const passwordInput = document.getElementById("password");
const passwordCriteria = document.getElementById("passwordCriteria");
const lengthCriteria = document.getElementById("lengthCriteria");
const uppercaseCriteria = document.getElementById("uppercaseCriteria");
const numberCriteria = document.getElementById("numberCriteria");
const specialCharCriteria = document.getElementById("specialCharCriteria");
passwordInput.addEventListener("focus", () => {
    passwordCriteria.style.display = "block";
});
passwordInput.addEventListener("blur", () => {
    passwordCriteria.style.display = "none";
});
function updatePasswordCriteria() {
    const password = passwordInput.value;

    toggleClass(lengthCriteria, password.length >= 8);
    toggleClass(uppercaseCriteria, /[A-Z]/.test(password));
    toggleClass(numberCriteria, /\d/.test(password));
    toggleClass(specialCharCriteria, /[!@#$%^&*(),.?":{}|<>]/.test(password));
}

function toggleClass(element, isValid) {
    if (isValid) {
        element.classList.add("valid");
        element.classList.remove("invalid");
    } else {
        element.classList.add("invalid");
        element.classList.remove("valid");
    }
}

passwordInput.addEventListener("change", updatePasswordCriteria);
async function submitForm(event) {
    event.preventDefault();
    const form = document.getElementById("signupForm");
    const formData = new FormData(form);
    const isValid = validateForm(event);
    if (!isValid) return;

    try {
        const response = await fetch("app/views/frontoffice/PHP/sign_in.php", {
            method: 'POST',
            body: formData
        });
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

document.getElementById("signupForm").addEventListener("submit", submitForm);
document.getElementById("role").addEventListener("change", toggleRole);
function validatelogin(event){
    event.preventDefault();
    const email=document.getElementById("loginEmail")
    const password=document.getElementById("loginPassword")
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
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
document.getElementById("loginForm").addEventListener("submit", validatelogin);