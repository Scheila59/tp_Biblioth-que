<?php

declare(strict_types=1);

// on déclare que les types des variables sont stricts

namespace App\Models;

// on définit l'espace de nom de la classe


class Livre // classe qui représente un livre
{
    private int $id; // propriété qui représente l'identifiant du livre
    private string $titre; // propriété qui représente le titre du livre
    private int $nbreDePages; // propriété qui représente le nombre de pages du livre
    private string $urlImage; // propriété qui représente l'url de l'image du livre
    private string $textAlternatif; // propriété qui représente le texte alternatif de l'image du livre
    private int|null $idUtilisateur;
    private string $uploader;

    public function __construct( // constructeur de la classe Livre
        int $id, // paramètre qui représente l'identifiant du livre
        string $titre, // paramètre qui représente le titre du livre
        int $nbreDePages, // paramètre qui représente le nombre de pages du livre
        string $urlImage, // paramètre qui représente l'url de l'image du livre
        string $textAlternatif, // paramètre qui représente le texte alternatif de l'image du livre
        int|null $idUtilisateur,
        string $uploader
    ) {
        $this->id = $id; // on affecte la valeur de l'identifiant du livre à la propriété id
        $this->titre = $titre; // on affecte la valeur du titre du livre à la propriété titre
        $this->nbreDePages = $nbreDePages; // on affecte la valeur du nombre de pages du livre à la propriété nbreDePages
        $this->urlImage = $urlImage; // on affecte la valeur de l'url de l'image du livre à la propriété urlImage
        $this->textAlternatif = $textAlternatif; // on affecte la valeur du texte alternatif de l'image du livre à la propriété textAlternatif
        $this->idUtilisateur = $idUtilisateur;
        $this->uploader = $uploader;
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int // méthode qui permet de récupérer l'identifiant du livre
    {
        return $this->id; // on retourne la valeur de la propriété id
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of titre
     *
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @param string $titre
     *
     * @return self
     */
    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * Get the value of nbreDePages
     *
     * @return int
     */
    public function getNbreDePages(): int
    {
        return $this->nbreDePages;
    }

    /**
     * Set the value of nbreDePages
     *
     * @param int $nbreDePages
     *
     * @return self
     */
    public function setNbreDePages(int $nbreDePages): self
    {
        $this->nbreDePages = $nbreDePages;
        return $this;
    }

    /**
     * Get the value of urlImage
     *
     * @return string
     */
    public function getUrlImage(): string
    {
        return $this->urlImage;
    }

    /**
     * Set the value of urlImage
     *
     * @param string $urlImage
     *
     * @return self
     */
    public function setUrlImage(string $urlImage): self
    {
        $this->urlImage = $urlImage;
        return $this;
    }

    /**
     * Get the value of textAlternatif
     *
     * @return string
     */
    public function getTextAlternatif(): string
    {
        return $this->textAlternatif;
    }

    /**
     * Set the value of textAlternatif
     *
     * @param string $textAlternatif
     *
     * @return self
     */
    public function setTextAlternatif(string $textAlternatif): self
    {
        $this->textAlternatif = $textAlternatif;
        return $this;
    }

    /**
     * Get the value of idUtilisateur
     *
     * @return int|null
     */
    public function getIdUtilisateur(): int|null
    {
        return $this->idUtilisateur;
    }

    /**
     * Set the value of idUtilisateur
     *
     * @param int|null $idUtilisateur
     *
     * @return self
     */
    public function setIdUtilisateur(int|null $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;
        return $this;
    }

    /**
     * Get the value of uploader
     *
     * @return string
     */
    public function getUploader(): string {
        return $this->uploader;
    }

    /**
     * Set the value of uploader
     *
     * @param string $uploader
     *
     * @return self
     */
    public function setUploader(string $uploader): self {
        $this->uploader = $uploader;
        return $this;
    }
}
