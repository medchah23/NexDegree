document.addEventListener("DOMContentLoaded", function () {
    var durationElement = document.getElementById("durée");
    var descriptionElement = document.getElementById("description");
    var maxScoreElement = document.getElementById("noteMax");
  
    
  
    durationElement.addEventListener("keyup", function () {
      var durationErrorElement = document.getElementById("durée_error");
      var durationValue = durationElement.value;
  
      if (durationValue < 15 || durationValue > 180) {
        durationErrorElement.innerHTML =
          "La durée doit être obligatoirement un entier et entre 15 et 180 minutes.";
        durationErrorElement.style.color = "red";
      } else {
        durationErrorElement.innerHTML = "Correct";
        durationErrorElement.style.color = "green";
      }
    });
  
    descriptionElement.addEventListener("keyup", function () {
      var descriptionErrorElement = document.getElementById("description_error");
      var descriptionValue = descriptionElement.value;
      var descriptionPattern = /^[A-Za-z\s]+$/; // Vérifie uniquement des lettres et des espaces
  
      if (descriptionValue.length < 10) {
        descriptionErrorElement.innerHTML =
          "La description doit contenir au moins 10 caractères.";
        descriptionErrorElement.style.color = "red";
      } else if (!descriptionPattern.test(descriptionValue)) {
        descriptionErrorElement.innerHTML =
          "La description doit contenir uniquement des lettres et des espaces.";
        descriptionErrorElement.style.color = "red";
      } else {
        descriptionErrorElement.innerHTML = "Correct";
        descriptionErrorElement.style.color = "green";
      }
    });
  
    // Validation de maxScore
    maxScoreElement.addEventListener("change", function () {
      var maxScoreErrorElement = document.getElementById("noteMax_error");
      var maxScoreValue = maxScoreElement.value;
      const valeursAutorisees = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
  
      if (!valeursAutorisees.includes(parseInt(maxScoreValue))) {
        maxScoreErrorElement.innerHTML =
          "Le score maximal doit être obligatoirement un entier entre 10, 20, 30, ..., 100.";
        maxScoreErrorElement.style.color = "red";
      } else {
        maxScoreErrorElement.innerHTML = "Correct";
        maxScoreErrorElement.style.color = "green";
      }
    });
  });
  