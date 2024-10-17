<?php

declare(strict_types=1);

namespace App\Models;

class Utilisateur
{
    private int $id_utilisateur;
    private string $identifiant;
    private string $password;
    private string $email;
    private string $role;
    private bool $is_valide;

    public function __construct(int $id_utilisateur, string $identifiant, string $password, string $email, string $role, bool $is_valide = FALSE)
    {
        $this->id_utilisateur = $id_utilisateur;
        $this->identifiant = $identifiant;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
        $this->is_valide = $is_valide;
    }
    


    public function getIdUtilisateur(): int
    {
        return $this->id_utilisateur;
    }


    public function setIdUtilisateur(int $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;
        return $this;
    }


    public function getIdentifiant(): string
    {
        return $this->identifiant;
    }


    public function setIdentifiant(string $identifiant): self
    {
        $this->identifiant = $identifiant;
        return $this;
    }


    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }


    public function getRole(): string
    {
        return $this->role;
    }


    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    
    public function getIsValide(): bool {
        return $this->is_valide;
    }

    
    public function setIsValide(bool $is_valide): self {
        $this->is_valide = $is_valide;
        return $this;
    }
}
