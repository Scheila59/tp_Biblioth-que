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
    private array $livres = [];

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
    public function ajouterLivreBdd(string $titre, int $nbreDePages, string $textAlternatif, string $nomImage) {
        // protection injection sql
        $req = "INSERT INTO livre (titre, nbre_De_Pages, url_Image ,text_Alternatif)VALUES 
        (:titre, :nbre_de_pages, :url_image, :text_alternatif)";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbre_de_pages", $nbreDePages, PDO::PARAM_INT);
        $stmt->bindValue(":url_image", $nomImage, PDO::PARAM_STR);
        $stmt->bindValue(":text_alternatif", $textAlternatif, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }
    public function modificationLivreBdd(string $titre, int $nbreDePages, string $textAlternatif, string $nomImage, int $idLivre) {
        $req = "UPDATE livre SET titre = :titre, nbre_De_Pages = :nbre_De_Pages, text_Alternatif = :text_Alternatif, url_Image = :url_Image WHERE id_livre = :id_livre";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue("id_livre", $idLivre, PDO::PARAM_INT);
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbre_De_Pages", $nbreDePages, PDO::PARAM_INT);
        $stmt->bindValue(":url_Image", $nomImage, PDO::PARAM_STR);
        $stmt->bindValue(":text_Alternatif", $textAlternatif, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function supprimerLivreBdd($idLivre) {
        $req = "DELETE FROM livre WHERE id_livre = :id_livre";
        $stmt = $this->getConnexionBdd()->prepare($req);
        $stmt->bindValue(":id_livre", $idLivre, PDO::PARAM_INT).
        $stmt->execute();
        $stmt->closeCursor();
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
