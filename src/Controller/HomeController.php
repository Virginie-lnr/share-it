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
        // $database = $connection->getDatabase();


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

            $newName = $uploadService->saveFile($uploadedFile);
        }

        // SQL

        return $this->template($response, 'home.html.twig');
    }

    public function download(ResponseInterface $response, int $id)
    {
        $response->getBody()->write(sprintf('Identifiants: %d', $id));
        return $response;
    }
}
