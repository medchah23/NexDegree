document.getElementById('noterForm').addEventListener(
    'submit', function (e){
        let note = document.getElementById('note');
        let max_score = document.getElementById('max_score');
        let remarque = document.getElementById('remarque');
        let remarque_error = document.getElementById('remarque_error');
        let note_error = document.getElementById('note_error');
        let hasError = false;

        if(!note.value || note.value < 0 || note.value > max_score.value){
                note_error.innerHTML = "La note doit etre entre 0 et max note : " + max_score.value;
                hasError = true;
        } else {
                note_error.innerHTML = '';
        }

        if(remarque.value.trim().length <= 0) {
                remarque_error.innerHTML = "Le champs remarque est requis";
                hasError = true;
        } else {
                remarque_error.innerHTML = '';
        }

        if (hasError) {
            e.preventDefault();
        }
    }
);