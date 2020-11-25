<?php

namespace App\Controller;

use App\File\UploadService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\UploadedFile;

class HomeController extends AbstractController
{
    public function homepage(
        ResponseInterface $response,
        ServerRequestInterface $request,
        UploadService  $uploadService,
        Connection $connection
    ) {
        $database = $connection->getDatabase();

        // récupérer les fichiers envoyés :
        $uploadedFiles = $request->getUploadedFiles();
        echo '<pre>';
        var_dump($_FILES);
        echo '</pre>';

        // vérifie si fichier a bien été envoyé
        if (isset($uploadedFiles['uploaded_file'])) {
            /** @var  */
            $uploadedFile = $uploadedFiles['uploaded_file'];
            // filename with original name 
            $filenameOriginal = $uploadedFile->getClientFileName();

            // Récupérer le nouveau nom du fichier 
            $newName = $uploadService->saveFile($uploadedFile);

            // 1- Méthode pour enregistrer les infos du fichier en base de données 
            $insertData = $connection->insert('files', array(
                'filename' => $newName,
                'original_filename' => $filenameOriginal
            ));

            // 2- autre méthodes pour insérer en bdd : 
            // $connection->executeStatement('INSERT INTO files (filename, original_filename) VALUES (:file, :origianl_filename)', 
            // [
            //     'filename' => $newName,
            //     'original_filename' => $filenameOriginal
            // ]);

            // Afficher un message à l'utilisateur 

        }


        return $this->template($response, 'home.html.twig');
    }

    public function download(ResponseInterface $response, int $id)
    {
        $response->getBody()->write(sprintf('Identifiants: %d', $id));
        return $response;
    }
}
