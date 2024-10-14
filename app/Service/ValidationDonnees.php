<?php

declare(strict_types=1); // déclaration du type strict

namespace App\Service; 

class ValidationDonnees
{
    private array $erreurs = []; // tableau de données contenant les erreurs

    public function valider(array $regles, array $datas) { // fonction qui valide les données
        foreach ($regles as $key => $regleTab) // pour chaque règle de validation
            if(array_key_exists($key, $datas)) { // si la clé existe dans les données
                foreach ($regleTab as $regle) { // pour chaque règle de validation
                    switch ($regle) { // on effectue la validation en fonction du type de règle
                        case 'required': // si la règle est "required"
                            $this->required($key, $datas[$key]); // on appelle la méthode required
                            break; // on sort de la boucle
                        case substr($regle, 0, 5) === 'match': // si la règle est "match"
                            $this->match($key, $datas[$key], $regle); // on appelle la méthode match
                            break; // on sort de la boucle
                        case substr($regle, 0, 3) === 'min': // si la règle est "min"
                            $this->min($key, $datas[$key], $regle); // on appelle la méthode min
                            break; // on sort de la boucle
                    }
                }
            }
    return $this->getErreurs(); // on retourne les erreurs
    }
    
    public function required(string $name, string|int|bool $data) // fonction qui valide si un champ est requis
    {
        $value = trim($data); // on nettoie le champ
        if (!isset($value) || empty($value) || is_null($value)) { // si le champ est vide ou n'est pas défini
            $this->erreurs[$name][] = "Le champ {$name} est requis!"; // on ajoute l'erreur au tableau
        }
    }

    private function min(string $name, string $value, string $regle): void 
    {
        // preg_match_all('/(\d+)/', $regle, $matches);
        // $limit = $matches[0][0]; // => 3
        $limit =  (int)substr($regle, 3); // on récupère le nombre de caractères minimum

        if (strlen($value) < $limit) { // si la longueur de la valeur est inférieure à la limite
            $this->erreurs[$name][] = "Le champ {$name} doit contenir un minimum de {$limit} caractères"; // on ajoute l'erreur au tableau
        }
    }

    public function match(string $name, string|int|bool $data, string $regle) // fonction qui valide si une valeur correspond à un pattern
    {
        $pattern = substr($regle, 6); // on récupère le pattern
        if (!preg_match($pattern, $data)) { // si la valeur ne correspond pas au pattern
            switch ($name) { // on effectue la validation en fonction du nom du champ
                case 'titre': // si le champ est "titre"
                    $this->erreurs[$name][] = "Le champ {$name} doit commencer par une lettre majuscule, contenir minimum 3 lettres et maximum 20 lettres, espaces et '-'(tiret du 6) autorisés"; // on ajoute l'erreur au tableau
                    break;
                case 'nbre-de-pages': // si le champ est "nbre-de-pages"
                    $this->erreurs[$name][] = "Le champ {$name} doit contenir uniquement des chiffres, [min: 1 - max: 10]";
                    break;
                case 'text-alternatif': // si le champ est "text-alternatif"
                    $this->erreurs[$name][] = "Le champ {$name} doit commencer par une lettre majuscule, contenir minimum 10 caractères et maximum 15à caracteres, espaces, '-'(tiret du 6), simple-quotes, double-quotes et point autorisés"; // on ajoute l'erreur au tableau
                    break;
            }
        }
        
    }
    /**
     * Get the value of erreurs
     *
     * @return array
     */
    public function getErreurs(): array {
        return $this->erreurs;
    }
}
