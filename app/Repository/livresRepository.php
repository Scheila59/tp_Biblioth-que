<?php

namespace App\Repository;

class livresRepository
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
    /**
     * Get All livres
     *
     * @return array
     */
    public function getLivres(): array{
        return $this->livres;
    }
}
