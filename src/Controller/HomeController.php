<?php

namespace App\Controller;

use App\Database\FileManager;
use App\File\UploadService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Psr7\UploadedFile;

class HomeController extends AbstractController
{
    public function homepage(
        ResponseInterface $response,
        ServerRequestInterface $request,
        UploadService  $uploadService,
        Connection $connection,
        FileManager $fileManager
    ) {
        $database = $connection->getDatabase();

        // récupérer les fichiers envoyés :
        $uploadedFiles = $request->getUploadedFiles();
        // echo '<pre>';
        // var_dump($_FILES);
        // echo '</pre>';

        // vérifie si fichier a bien été envoyé
        if (isset($uploadedFiles['uploaded_file'])) {
            /** @var  */
            $uploadedFile = $uploadedFiles['uploaded_file'];
            // filename with original name 
            $filenameOriginal = $uploadedFile->getClientFileName();

            // Récupérer le nouveau nom du fichier 
            $newName = $uploadService->saveFile($uploadedFile);

            // 1- Méthode insert() pour enregistrer les infos du fichier en base de données 
            $files = $fileManager->createFichier($newName, $filenameOriginal);
            // $connection->insert('files', array(
            //     'filename' => $newName,
            //     'original_filename' => $filenameOriginal
            // ));

            // 2- méthode executeStatement() pour insérer en bdd : 
            // $connection->executeStatement('INSERT INTO files (filename, original_filename) VALUES (:file, :origianl_filename)', 
            // [
            //     'filename' => $newName,
            //     'original_filename' => $filenameOriginal
            // ]);

            // 3- méthode prepare() (style PDO)
            // $query = $connection->prepare('INSERT INTO fichier (nom, nom_original) VALUES (:nom, :nom_original)');
            // $query->bindValue('nom', $nouveauNom);
            // $query->bindValue('nom_original', $fichier->getClientFilename());
            // $query->execute();

            // 4- méthode Query Builder
            // $queryBuilder = $connection->createQueryBuilder();
            // $queryBuilder
            // ->insert('fichier')
            // ->values([
            //     'nom' => $nouveauNom,
            //     'nom_original' => $fichier->getClientFilename(),
            // ]);
            // $queryBuilder->execute();

            // Afficher un message à l'utilisateur 

            // Rediction vers la page success 
            return $this->redirect('success', [
                'id' => $files->getId()
            ]);
        }

        return $this->template($response, 'home.html.twig');
    }

    /**
     * vérifier que l'identifiant (argument id) correspond à un fichier existant
     * si ce n'est pas le cas, rediriger vers une route qui affichera un msg d'erreur
     */
    public function success(ResponseInterface $response, int $id, Connection $connection, FileManager $fileManager)
    {

        $files = $fileManager->getById($id);

        if ($files === null) {
            return $this->redirect('file-error');
        }

        return $this->template($response, 'success.html.twig', [
            'files' => $files
        ]);
    }

    public function fileError(ResponseInterface $response)
    {
        return $this->template($response, 'file_error.html.twig');
    }

    public function download(
        ResponseInterface $response,
        int $id,
        Connection $connection,
        FileManager $fileManager
    ) {

        $files = $fileManager->getById($id);

        if ($files === null) {
            return $this->redirect('file-error');
        }

        $originalFileName = $files->getNomOriginal();
        $fileName = $files->getNom();

        $pathFileName = __DIR__ . '/../../files/' . $fileName;
        $pathFileNameOriginal = __DIR__ . '/../../files/' . $originalFileName;

        if (file_exists($pathFileName)) {
            header('Content-Disposition: attachment;filename="' . basename($pathFileNameOriginal) . '"');
            readfile($pathFileName);
            exit;
        }

        return $response;
    }
}
