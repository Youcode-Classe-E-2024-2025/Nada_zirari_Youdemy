
    // Fonction de validation du formulaire de connexion
    function validateLoginForm() {
        let isValid = true;

        // Validation de l'email
        const email = document.getElementById('email').value;
        const emailError = document.getElementById('emailError');
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // validation de l'email
        if (!emailPattern.test(email)) {
            emailError.textContent = "L'email doit être valide (exemple@domaine.com).";
            isValid = false;
        } else {
            emailError.textContent = "";
        }

        // Validation du mot de passe
        const password = document.getElementById('password').value;
        const passwordError = document.getElementById('passwordError');
        
        // Expression régulière pour vérifier la combinaison des lettres, chiffres et caractères spéciaux
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).+$/; 
        
        if (password.length === 0) {
            passwordError.textContent = "Le mot de passe ne peut pas être vide.";
            isValid = false;
        } else if (!passwordPattern.test(password)) {
            passwordError.textContent = "Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.";
            isValid = false;
        } else {
            passwordError.textContent = "";
        }

        // Retourner false pour empêcher l'envoi du formulaire si la validation échoue
        return isValid;
    }