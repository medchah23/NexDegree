document.getElementById('formAdd').addEventListener('submit', function (e) {
  let duree = document.getElementById('duree');
  let noteMax = document.getElementById('noteMax');
  let date2 = document.getElementById('date2');
  let quest1 = document.getElementById('quest1');
  let quest2 = document.getElementById('quest2');
  let quest3 = document.getElementById('quest3');
  let quest4 = document.getElementById('quest4');
  let quest5 = document.getElementById('quest5');

  let hasError = false;
  let errorD = document.getElementById('duree_error');
  let noteMax_error = document.getElementById('noteMax_error');
  let date_error = document.getElementById('date_error');
  let quest1_error = document.getElementById('quest1_error');
  let quest2_error = document.getElementById('quest2_error');
  let quest3_error = document.getElementById('quest3_error');
  let quest4_error = document.getElementById('quest4_error');
  let quest5_error = document.getElementById('quest5_error');

  if(duree.value <= 0 || !duree.value){
    errorD.innerHTML = "Durée est obligatoire et doit etre sup à 0";
    hasError = true;
  } else {
    errorD.innerHTML = '';
    hasError = false;
  }

  if(!noteMax.value || noteMax.value <= 0){
    noteMax_error.innerHTML = "Note est obligatoire et doit etre sup à 0";
    hasError = true;
  } else {
    noteMax_error.innerHTML = '';
    hasError = false;
  }

  if(!date2.value){
    date_error.innerHTML = "Date est obligatoire";
    hasError = true;
  } else {
    date_error.innerHTML = '';
    hasError = false;
  }

  if(quest1.value.trim().length <= 0){
    quest1_error.innerHTML = "Question 1 est obligatoire";
    hasError = true;
  } else {
    quest1_error.innerHTML = '';
    hasError = false;
  }

  if(quest2.value.trim().length <= 0){
    quest2_error.innerHTML = "Question 2 est obligatoire";
    hasError = true;
  } else {
    quest2_error.innerHTML = '';
    hasError = false;
  }

  if(quest3.value.trim().length <= 0){
    quest3_error.innerHTML = "Question 3 est obligatoire";
    hasError = true;
  } else {
    quest3_error.innerHTML = '';
    hasError = false;
  }

  if(quest4.value.trim().length <= 0){
    quest4_error.innerHTML = "Question 4 est obligatoire";
    hasError = true;
  } else {
    quest4_error.innerHTML = '';
    hasError = false;
  }

  if(quest5.value.trim().length <= 0){
    quest5_error.innerHTML = "Question 5 est obligatoire";
    hasError = true;
  } else {
    quest5_error.innerHTML = '';
    hasError = false;
  }

  if(hasError)
    e.preventDefault();
});