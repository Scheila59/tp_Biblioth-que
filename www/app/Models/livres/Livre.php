<?php

declare(strict_types=1);

class Livre {
    private int $id;
    private string $titre;
    private int $nbreDePages;
    private string $urlImage;
    private string $textAlternatif;

    public function __construct(int $id,string $titre,int $nbreDePages,string $urlImage,string $textAlternatif
            ){
            $this->id = $id;
            $this->titre = $titre;
            $this->nbreDePages = $nbreDePages;
            $this->urlImage = $urlImage;
            $this->textAlternatif= $textAlternatif;        
    }
    
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    
    public function setTitre(string $titre): self {
        $this->titre = $titre;
        return $this;
    }

    
    public function getNbreDePages(): int {
        return $this->nbreDePages;
    }

    
    public function setNbreDePages(int $nbreDePages): self {
        $this->nbreDePages = $nbreDePages;
        return $this;
    }

    
    public function getUrlImage(): string {
        return $this->urlImage;
    }

    
    public function setUrlImage(string $urlImage): self {
        $this->urlImage = $urlImage;
        return $this;
    }

    
    public function getTextAlternatif(): string {
        return $this->textAlternatif;
    }

    
    public function setTextAlternatif(string $textAlternatif): self {
        $this->textAlternatif = $textAlternatif;
        return $this;
    }
}