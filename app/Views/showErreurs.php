

<?php if (isset($_SESSION['erreurs'])) {
    foreach ($_SESSION['erreurs'] as $erreursTab) { // afficher les erreurs
        foreach ($erreursTab as $erreurs) { // afficher les erreurs
            $divErreur = "<div class='alert alert-danger w-100 m-auto' style='max-width:781px'><ul>"; // créer un div pour les erreurs
            foreach ($erreurs as $erreur) { // afficher les erreurs
                $divErreur .= "<li>$erreur</li>";
            }
            $divErreur .= '</ul></div>'; // fermer le div
            unset($_SESSION['erreurs']); // supprimer les erreurs
            echo $divErreur; // afficher les erreurs
        }
    }
}
