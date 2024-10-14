<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\AbstractConnexion;

class UtilisateurRepository  extends AbstractConnexion
{
    public function getUtilisateurByEmail(string $email) {
        $req = "SELECT * FROM utilisateur WHERE email = ?";
        $stmt = $this->getConnexion()->prepare($req);
        $stmt->execute([$email]);
        $stmt->CloseCursor();
    }
}
