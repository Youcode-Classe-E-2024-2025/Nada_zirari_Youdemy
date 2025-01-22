    /*Toggle dropdown list*/
    function toggleDD(myDropMenu) {
        document.getElementById(myDropMenu).classList.toggle("invisible");
    }
    /*Filter dropdown options*/
    function filterDD(myDropMenu, myDropMenuSearch) {
        var input, filter, ul, li, a, i;
        input = document.getElementById(myDropMenuSearch);
        filter = input.value.toUpperCase();
        div = document.getElementById(myDropMenu);
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }
    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.drop-button') && !event.target.matches('.drop-search')) {
            var dropdowns = document.getElementsByClassName("dropdownlist");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (!openDropdown.classList.contains('invisible')) {
                    openDropdown.classList.add('invisible');
                }
            }
        }
    }


     // Fonction pour afficher la section correspondante
     function showSection(section) {
        // Masquer toutes les sections
        const sections = document.querySelectorAll('.section');
        sections.forEach(function (sec) {
            sec.classList.add('hidden');
        });

        // Afficher la section demandée
        const sectionToShow = document.getElementById(section);
        if (sectionToShow) {
            sectionToShow.classList.remove('hidden');
        }
    }

    // Attendez que le DOM soit complètement chargé avant d'exécuter le script
    document.addEventListener('DOMContentLoaded', function () {
        // Afficher la section Analytics par défaut après le chargement de la page
        showSection('analytics');
    });