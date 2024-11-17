// Select the wrapper and form headers
const wrapper = document.querySelector(".wrapper");
const signupHeader = document.querySelector(".form.signup header");
const loginHeader = document.querySelector(".form.login header");

// Add event listeners to toggle between login and signup forms
loginHeader.addEventListener("click", () => {
    wrapper.classList.add("active");
});

signupHeader.addEventListener("click", () => {
    wrapper.classList.remove("active");
});
function togglestudent() {
    const role = document.getElementById('role').value; // Get selected role value
    const student = document.getElementById('student'); // Student section
    const prof = document.getElementById('prof'); // Teacher section

    if (role === 'etudient') {
        student.style.display = 'block'; // Show student section
        prof.style.display = 'none'; // Hide teacher section
    } else if (role === 'prof') {
        prof.style.display = 'block'; // Show teacher section
        student.style.display = 'none'; // Hide student section
    } else {
        // Default case: Hide both sections
        student.style.display = 'none';
        prof.style.display = 'none';
    }
}

function createPopupb(message, status, callback = null) {
    // Remove any existing popup
    const existingPopup = document.querySelector('.popup');
    if (existingPopup) {
        existingPopup.remove();
    }

    const popup = document.createElement('div');
    popup.classList.add('popup', status);

    // Create message element
    const messageElement = document.createElement('div');
    messageElement.innerText = message;
    popup.appendChild(messageElement);

    // Create button container if callback is provided
    if (callback) {
        const buttonContainer = document.createElement('div');
        buttonContainer.classList.add('button-container');

        const confirmButton = document.createElement('button');
        confirmButton.classList.add('confirm-button');
        confirmButton.innerText = 'Confirm';
        confirmButton.onclick = () => {
            callback(true);
            document.body.removeChild(popup);
        };
        const cancelButton = document.createElement('button');
        cancelButton.classList.add('cancel-button');
        cancelButton.innerText = 'Cancel';
        cancelButton.onclick = () => {
            callback(false);
            document.body.removeChild(popup);
        };
        buttonContainer.appendChild(confirmButton);
        buttonContainer.appendChild(cancelButton);

        popup.appendChild(buttonContainer);
    }
    document.body.appendChild(popup);
    setTimeout(() => {
        popup.classList.add('show');
    }, 10);
    if (!callback) {
        setTimeout(() => {
            popup.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(popup);
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
            document.body.removeChild(popup);
        }, 300);
    }, 3000);
}
function ischaine(ch) {
    let b = false;
    let i = 0;
    while (!b && i < ch.length) {
        const char = ch[i].toUpperCase();
        if (char > "Z" || char < "A") {
            b = true;
        } else {
            i++;
        }
    }
    return b;
}
function removeShakeAnimation(element) {
    element.addEventListener('animationend', () => {
        element.classList.remove('error');
    });
}
function verif(event) {
    event.preventDefault();
    nom = document.getElementById("firstName");
    prenom = document.getElementById('secondName');
    email = document.getElementById('email');
    tele= document.getElementById('tel');
    role = document.getElementById('role');
    niveau = document.getElementById('niveau');
    image_student = document.getElementById('student_image');
    matier = document.getElementById('matier');
    cv= document.getElementById('cv');
    isValid=true
    if (ischaine(nom.value)===false || nom.value ==="") {
        nom.value = "";
        nom.placeholder = "nom not valid";
        nom.classList.add("error");
        removeShakeAnimation(nom);
        isValid = false;
    }
    else if (ischaine(prenom.value)==false|| prenom.value=="") {
        prenom.value = "";
        prenom.placeholder = "prenom not valid";
        nom.classList.add("error");
        removeShakeAnimation(prenom);
        isValid = false;

    }
    const test = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    else if (!test.test(email.value)) {
        email.value="";
        email.placeholder = "email address non valide";
        email.classList.add("error");
        removeShakeAnimation(test);
        isValid = false;
    }
    else if()

}

/*document.getElementById('signupForm').addEventListener('submit', signin);
document.getElementById('loginForm').addEventListener('submit', login);
*/