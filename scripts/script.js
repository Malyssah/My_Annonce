 //désactiver les soumissions de formulaire s'il existe des champs non valides
 (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Récupérer tous les formulaires auxquels nous voulons appliquer des styles de validation Bootstrap personnalisés
      var forms = document.getElementsByClassName('needs-validation');
      // Boucle sur eux et empêcher la soumission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();

  