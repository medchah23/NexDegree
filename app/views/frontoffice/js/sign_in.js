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
function toggleCategoryInput() {
    const role = document.getElementById('role');
    const PROF = document.getElementById('PROF');
    if (role.value === 'prof') {
        PROF.style.display = 'block';
    } else {
        PROF.style.display = 'none';
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
    nom = document.getElementById("firstName")
    prenom = document.getElementById('secondName');
    email = document.getElementById('email');
    telefone = document.getElementsByClassName('tele');

}
/*document.getElementById('signupForm').addEventListener('submit', signin);
document.getElementById('loginForm').addEventListener('submit', login);
*/