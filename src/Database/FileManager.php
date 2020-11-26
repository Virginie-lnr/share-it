<?php

namespace App\Database;

use Doctrine\DBAL\Connection;

use function DI\create;

/**
 * Ce service est en charge de la gestion des données de la table 'files'
 * Elle doit utiliser des objets de la classe Files 
 */

class FileManager
{
  private Connection $connection;

  /**
   * Les objets FileManager pourront être demandés en arguments dans les controlleurs 
   * Pour les instancier, le conteneur de services va lire la liste d'arguments du constructeur 
   * Ici, il va d'baord instancier le servicer Connection pour pouvoir instancier FileManager 
   */

  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
  }

  /**
   * Récupérer un ficher par son id 
   * 
   * @param int $id l'idendifiant en base du fichier 
   * @return Files/null le fichier trouvé ou null en l'absence de résultat 
   */

  public function getById(int $id): ?Files
  {
    $query = $this->connection->prepare('SELECT * from files WHERE id = :id');
    $query->bindValue('id', $id);
    $result = $query->execute();
    // tableau associatif contenant les données du fichier, ou false si aucun résultat
    $fichierData = $result->fetchAssociative();

    if ($fichierData === false) {
      return null;
    }

    // Création d'une instance de Fichier 
    return $this->createObject($fichierData['id'], $fichierData['filename'], $fichierData['original_filename']);
  }

  /**
   * Enregistrer un nouveau fichier en base de données 
   */
  public function createFichier(string $filename, string $original_filename) // : Files
  {
    // Enregistrer en base de données (voir HomeController:homepage() )
    // 1- Méthode insert() pour enregistrer les infos du fichier en base de données 
    $this->connection->insert('files', array(
      'filename' => $filename,
      'original_filename' => $original_filename
    ));

    // Récupérer l'identifiant généré du fichier enregistré 
    $id = $this->connection->lastInsertId();

    // Créer un objet Fichier et le retourner : créer une méthode createObject

    return $this->createObject($id, $filename, $original_filename);
  }

  private function createObject(int $id, string $filename, string $original_filename): Files
  {
    $files = new Files();
    $files
      ->setId($id)
      ->setNom($filename)
      ->setNomOriginal($original_filename);
    return $files;
  }
}
