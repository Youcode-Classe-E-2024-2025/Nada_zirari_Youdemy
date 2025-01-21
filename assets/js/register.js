
    // Fonction de validation du formulaire
    function validateForm() {
        let isValid = true;

        // Validation du nom d'utilisateur
        const username = document.getElementById('username').value;
        const usernameError = document.getElementById('usernameError');
        const usernamePattern = /^[a-zA-Z]+$/; // uniquement des lettres
        if (username.length <= 4 || !usernamePattern.test(username)) {
            usernameError.textContent = "Le nom d'utilisateur doit contenir uniquement des lettres et être plus long que 4 caractères.";
            isValid = false;
        } else {
            usernameError.textContent = "";
        }

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
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).+$/; // minuscule, majuscule, chiffre, caractère spécial
        if (!passwordPattern.test(password)) {
            passwordError.textContent = "Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.";
            isValid = false;
        } else {
            passwordError.textContent = "";
        }

        // Validation de la confirmation du mot de passe
        const confirmPassword = document.getElementById('confirmPassword').value;
        const confirmPasswordError = document.getElementById('confirmPasswordError');
        if (password !== confirmPassword) {
            confirmPasswordError.textContent = "Les mots de passe ne correspondent pas.";
            isValid = false;
        } else {
            confirmPasswordError.textContent = "";
        }

        // Retourner false pour empêcher l'envoi du formulaire si la validation échoue
        return isValid;
    }
