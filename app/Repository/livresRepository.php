<?php
declare(strict_types=1);

namespace App\Repository;

use PDO;
use App\Models\Livre;
use App\Service\AbstractConnexion;

class livresRepository extends AbstractConnexion 
{
    /**
     * Tableau de livres
     *
     * @var array
     */
    private array $livres;

    public function ajouterLivre(object $nouveauLivre) {
        $this->livres[] = $nouveauLivre;
    }

    public function chargementLivresBdd(){
        // protection injection SQL
        $req = $this->getConnexionBdd()->prepare("SELECT * FROM livre");
        $req->execute();
        $livresImportes = $req->fetchALL(PDO::FETCH_ASSOC);
        $req->closeCursor();
        foreach($livresImportes as $livre) {
            $newLivre = new Livre($livre['id_livre'], $livre['titre'],$livre['nbre_De_Pages'], $livre['url_Image'], $livre['text_Alternatif']);
            $this->ajouterLivre($newLivre);
        }
    }

    public function getLivreById($idLivre) {
        $this->getLivres();
        foreach ($this->livres as $livre) {
            if ($livre->getId()=== $idLivre) {
                return $livre;
            }
        }
    }
    /**
     * Get All livres
     *
     * @return array
     */
    public function getLivres(): array{
        return $this->livres;
    }
}
