document.getElementById('reponseForm').addEventListener('submit', function (e) {
    let hasError = false;

    for (let i = 1; i <= 5; i++) {
        let questionField = document.getElementById('question' + i);
        let errorField = document.getElementById('quest' + i + '_error');

        if (questionField.value.trim() === '') {
            errorField.innerHTML = "Ce champ est obligatoire.";
            hasError = true;
        } else {
            errorField.innerHTML = "";
        }
    }

    if (hasError) {
        e.preventDefault();
    }
});