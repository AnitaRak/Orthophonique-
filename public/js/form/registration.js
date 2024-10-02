const noAdeliInput = document.getElementById('registration_form_no_adeli');

noAdeliInput.addEventListener('input', function() {
  const value = this.value;
  if (value.length === 9) {
    // Champ valide : vert
    this.classList.add('is-valid');
    this.classList.remove('is-invalid');
  } else if (value.length > 0) {
    // Champ invalide : rouge
    this.classList.add('is-invalid');
    this.classList.remove('is-valid');
  } else {
    // Champ vide : par défaut
    this.classList.remove('is-valid');
    this.classList.remove('is-invalid');
  }
});