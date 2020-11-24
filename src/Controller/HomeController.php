<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\UploadedFile;

class HomeController extends AbstractController
{
    public function homepage(ResponseInterface $response, ServerRequestInterface $request)
    {
        // $database = $connection->getDatabase();


        // récupérer les fichiers envoyés :
        $uploadedFiles = $request->getUploadedFiles();
        echo '<pre>';
        var_dump($_FILES);
        echo '</pre>';

        // vérifie si fichier a bien été envoyé
        if (isset($uploadedFiles['uploaded_file'])) {
            $uploadedFile = $uploadedFiles['uploaded_file'];
        }

        // filename 
        $filename = $_FILES['uploaded_file']['tmp_name'];

        // directory 
        $directory = __DIR__ . '/../../files/';
        $uploadfile = $directory . basename($_FILES['uploaded_file']['name']);


        // vérifie s'il n'y a pas eu d'erreur et déplace le fichier
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            echo ("Fichier téléchargé: " . $_FILES['uploaded_file']["name"]);
            move_uploaded_file($filename, $uploadfile);
        }

        return $this->template($response, 'home.html.twig');
    }

    public function download(ResponseInterface $response, int $id)
    {
        $response->getBody()->write(sprintf('Identifiants: %d', $id));
        return $response;
    }
}
