<?php

namespace App\Database;

/**
 * Les objets de la classe Fichier représentent les données de la table 'files' 
 * 1 instance = 1 ligne 
 */
class Files
{
  /** 
   * PHP 7.4 et +     
   * private ?int $id = null;
   * PHP < 7.4:     
   * private $id;
   */
  private ?int $id = null; // entier ou null (?int)
  private ?string $filename = null;
  private ?string $original_filename = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(int $id): self
  {
    $this->id = $id;
    return $this;
  }

  public function getNom(): ?string
  {
    return $this->filename;
  }

  public function setNom(string $filename): self
  {
    $this->filename = $filename;
    return $this;
  }

  public function getNomOriginal(): ?string
  {
    return $this->original_filename;
  }

  public function setNomOriginal(string $original_filename): self
  {
    $this->original_filename = $original_filename;
    return $this;
  }
}
