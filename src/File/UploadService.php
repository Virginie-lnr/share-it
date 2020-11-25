<?php

// src/File/UploadService.php
namespace App\File;

use Psr\Http\Message\UploadedFileInterface;

/**
 * Service en charge de l'enregistrement de fichiers 
 */
class UploadService
{
  /**
   * @var string chemin vers le dossier où enregistrer les fichiers 
   */
  public const FILES_DIR = __DIR__ . '/../../files';
  /** 
   * Enregistrer un fichier 
   * 
   * @param UploadedFileInterface $file le fichier chargé à enregistrer 
   * @return string le nouveau nom du fichier ou null en cas d'erreurs 
   */
  public function saveFile(UploadedFileInterface $file) // : string
  {

    $filename = $this->generateFilename($file);

    // chemin de destination du fichier 
    // chemin vers le dossier /files/ + nouveau nom de fichier
    $directory = self::FILES_DIR . '/' . $filename;

    // Déplacer le fichier
    $file->moveTo($directory);
    return $filename;
  }

  /** 
   * Générer un nom de fichier aléatoire et unique 
   * 
   * @param UploadedFileInterface $file le fichier à enregistrer 
   * @return string le nom unique généré
   */

  public function generateFilename(UploadedFileInterface $file) // : string
  {
    /** 
     * Ecrire le code generateFilename() -> code existant au dessus
     * Utiliser la méthode generateFilename() dans la méthode saveFile()
     * Ajouter un argument de la class UploadService dans le HomeController et utiliser la méthode saveFile()
     */

    // random string 
    $randomString = bin2hex(random_bytes(5));
    // date + random string + original filename 
    $filename = date("YmdHis");
    $filename .= $randomString;
    // la méthode pathinfo() permet de sélection uniquement l'exention du fichier  
    // grâce à PATHINFO_EXTENSION
    $filename .= '.' . pathinfo($file->getClientFileName(), PATHINFO_EXTENSION);
    return $filename;
  }
}
