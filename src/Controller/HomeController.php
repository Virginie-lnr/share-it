<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;

class HomeController extends AbstractController
{
    public function homepage(ResponseInterface $response)
    {
        // $database = $connection->getDatabase();

        return $this->template($response, 'home.html.twig');
    }

    public function download(ResponseInterface $response, int $id)
    {
        $response->getBody()->write(sprintf('Identifiants: %d', $id));
        return $response;
    }
}
