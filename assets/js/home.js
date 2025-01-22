var canvas = document.getElementById('monCanvas');
var ctx = canvas.getContext('2d');

// Mise à jour de la taille du canvas pour occuper toute la fenêtre
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

var balls = []; // Un tableau pour toutes les boules

// Liste d'abréviations des matières
var abbreviations = ["Maths", "Phys", "Info", "Bio", "Chim", "Hist", "Géo", "Litt", "Philo", "Ang"];

// Créer des boules avec des tailles et des positions aléatoires
for (var i = 0; i < 50; i++) { // Crée 50 boules
    var ballRadius = 10 + Math.random() * 30; // Rayon aléatoire entre 10 et 40
    var abbreviation = abbreviations[Math.floor(Math.random() * abbreviations.length)]; // Choisir une abréviation aléatoire

    balls.push({
        x: Math.random() * (canvas.width - ballRadius * 2), // Position horizontale aléatoire
        y: canvas.height + ballRadius, // Position verticale initiale (en bas de l'écran)
        color: '#0c4d2e', // Couleur de la boule
        radius: ballRadius, // Rayon de la boule
        speed: 2 + Math.random() * 1, // Vitesse aléatoire des boules
        abbreviation: abbreviation // L'abréviation à afficher dans la boule
    });
}

// Ajouter une fonction pour vérifier si la souris est sur une boule
function isMouseOverBall(mouseX, mouseY, ball) {
    var dist = Math.sqrt((mouseX - ball.x) ** 2 + (mouseY - ball.y) ** 2);
    return dist <= ball.radius;
}

// Ajout d'un gestionnaire d'événement pour le survol de la souris
canvas.addEventListener('mousemove', function(event) {
    var mouseX = event.clientX;
    var mouseY = event.clientY;

    // Parcourir toutes les boules et changer leur couleur si la souris les survole
    balls.forEach(function(ball) {
        if (isMouseOverBall(mouseX, mouseY, ball)) {
            ball.color = '#1c073b'; // Changer la couleur au survol 
        } else {
            ball.color = '#0c4d2e'; // Couleur par défaut
        }
    });
});

// Fonction pour dessiner une boule avec un texte à l'intérieur
function drawBall(x, y, radius, abbreviation, color) {
    ctx.beginPath();
    ctx.arc(x, y, radius, 0, Math.PI * 2);
    ctx.fillStyle = color;  // Utiliser la couleur de la boule
    ctx.fill();
    ctx.closePath();

    // Afficher du texte uniquement dans les grandes boules (rayon > 30)
    if (radius > 30) {
        ctx.fillStyle = "white"; // Couleur du texte
        ctx.font = "bold " + Math.min(radius / 2, 20) + "px Arial"; // Taille du texte en fonction du rayon
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.fillText(abbreviation, x, y);
    }
}

// Fonction pour mettre à jour la position des boules
function updateBalls() {
    ctx.clearRect(0, 0, canvas.width, canvas.height); // Effacer le canvas à chaque image

    balls.forEach(function (ball) {
        ball.y -= ball.speed; // Déplacer la boule vers le haut

        // Si la boule sort du canvas par le haut, elle réapparaît en bas
        if (ball.y + ball.radius < 0) {
            ball.y = canvas.height + ball.radius;  // Réinitialiser la position au bas du canvas
        }

        // Dessiner la boule avec sa couleur modifiée et son abréviation
        drawBall(ball.x, ball.y, ball.radius, ball.abbreviation, ball.color);
    });

    // Répéter l'animation
    requestAnimationFrame(updateBalls);
}

// Démarrer l'animation
updateBalls();

// Redimensionner le canvas si la fenêtre change de taille
window.addEventListener('resize', function () {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});