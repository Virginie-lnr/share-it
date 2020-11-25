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
            /** @var  */
            $uploadedFile = $uploadedFiles['uploaded_file'];
        }

        // filename with original name 
        $filenameOriginal = $uploadedFile->getClientFileName();

        // random string 
        $randomString = bin2hex(random_bytes(5));
        // date + random string + original filename 
        $filename = date("YmdHis");
        $filename .= $randomString;
        // la méthode pathinfo() permet de sélection uniquement l'exention du fichier  
        // grâce à PATHINFO_EXTENSION
        $filename .= '.' . pathinfo($filenameOriginal, PATHINFO_EXTENSION);
        echo '<hr>';

        // chemin de destination du fichier 
        // chemin vers le dossier /files/ + nouveau nom de fichier
        $directory = __DIR__ . '/../../files/' . $filename;

        // vérifie s'il n'y a pas eu d'erreur et déplace le fichier
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            // move_uploaded_file($filename, $uploadFileDirectory);
            $uploadedFile->moveTo($directory);
            echo ("Votre fichier " . $filename . " a bien été envoyé!");
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
