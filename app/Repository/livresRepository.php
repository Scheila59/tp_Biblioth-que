<?php
declare(strict_types=1);

namespace App\Repository; // nom du namespace

use PDO; // classe PDO pour la connexion à la base de données
use App\Models\Livre; // classe Livre pour les objets livres
use App\Service\AbstractConnexion; // classe AbstractConnexion pour la connexion à la base de données

class livresRepository extends AbstractConnexion // classe livresRepository qui hérite de AbstractConnexion
{
    /**
     * Tableau de livres
     *
     * @var array
     */
    private array $livres = []; // tableau de livres    

    public function ajouterLivre(object $nouveauLivre) { // méthode pour ajouter un livre au tableau
        $this->livres[] = $nouveauLivre; // ajout du livre au tableau
    }

    public function chargementLivresBdd(){ // méthode pour charger les livres depuis la base de données
        // protection injection SQL
        $req = $this->getConnexionBdd()->prepare("SELECT * FROM livre"); // requête SQL pour récupérer tous les livres
        $req->execute(); // exécution de la requête
        $livresImportes = $req->fetchALL(PDO::FETCH_ASSOC); // récupération de tous les livres sous forme de tableau associatif
        $req->closeCursor(); // fermeture du curseur
        foreach($livresImportes as $livre) { // boucle pour chaque livre
            $newLivre = new Livre($livre['id_livre'], $livre['titre'],$livre['nbre_De_Pages'], $livre['url_Image'], $livre['text_Alternatif']);
            $this->ajouterLivre($newLivre);
        }
    }

    public function getLivreById($idLivre) { // méthode pour récupérer un livre par son id
        $this->getLivres(); // appel de la méthode getLivres
        foreach ($this->livres as $livre) { // boucle pour chaque livre
            if ($livre->getId()=== $idLivre) { // si l'id du livre est égal à l'id passé en paramètre
                return $livre; // retour du livre
            }
        }
    }
    public function ajouterLivreBdd(string $titre, int $nbreDePages, string $textAlternatif, string $nomImage) {
        // protection injection sql requête SQL pour ajouter un livre
        $req = "INSERT INTO livre (titre, nbre_De_Pages, url_Image ,text_Alternatif)VALUES 
        (:titre, :nbre_de_pages, :url_image, :text_alternatif)";
        $stmt = $this->getConnexionBdd()->prepare($req); // préparation de la requête
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR); // liaison de la valeur du titre avec le paramètre titre
        $stmt->bindValue(":nbre_de_pages", $nbreDePages, PDO::PARAM_INT); // liaison de la valeur du nombre de pages avec le paramètre nbre_de_pages
        $stmt->bindValue(":url_image", $nomImage, PDO::PARAM_STR); // liaison de la valeur de l'url de l'image avec le paramètre url_image
        $stmt->bindValue(":text_alternatif", $textAlternatif, PDO::PARAM_STR); // liaison de la valeur du texte alternatif avec le paramètre text_alternatif
        $stmt->execute(); // exécution de la requête
        $stmt->closeCursor(); // fermeture du curseur 
    }
    public function modificationLivreBdd(string $titre, int $nbreDePages, string $textAlternatif, string $nomImage, int $idLivre) { // méthode pour modifier un livre
        $req = "UPDATE livre SET titre = :titre, nbre_De_Pages = :nbre_De_Pages, text_Alternatif = :text_Alternatif, url_Image = :url_Image WHERE id_livre = :id_livre"; // requête SQL pour modifier un livre
        $stmt = $this->getConnexionBdd()->prepare($req); // préparation de la requête
        $stmt->bindValue("id_livre", $idLivre, PDO::PARAM_INT); // liaison de la valeur de l'id du livre avec le paramètre id_livre
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR); // liaison de la valeur du titre avec le paramètre titre
        $stmt->bindValue(":nbre_De_Pages", $nbreDePages, PDO::PARAM_INT); // liaison de la valeur du nombre de pages avec le paramètre nbre_De_Pages
        $stmt->bindValue(":url_Image", $nomImage, PDO::PARAM_STR); // liaison de la valeur de l'url de l'image avec le paramètre url_Image
        $stmt->bindValue(":text_Alternatif", $textAlternatif, PDO::PARAM_STR); // liaison de la valeur du texte alternatif avec le paramètre text_Alternatif
        $stmt->execute(); // exécution de la requête
        $stmt->closeCursor(); // fermeture du curseur 
    }

    public function supprimerLivreBdd($idLivre) { // méthode pour supprimer un livre
        $req = "DELETE FROM livre WHERE id_livre = :id_livre"; // requête SQL pour supprimer un livre
        $stmt = $this->getConnexionBdd()->prepare($req); // préparation de la requête
        $stmt->bindValue(":id_livre", $idLivre, PDO::PARAM_INT); // liaison de la valeur de l'id du livre avec le paramètre id_livre
        $stmt->execute(); // exécution de la requête
        $stmt->closeCursor(); // fermeture du curseur 
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
