<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ErrorController extends AbstractController
{
    public function showException(FlattenException $exception): Response
    {
        $statusCode = $exception->getStatusCode();

        if ($statusCode === 404) {
            return $this->render('error/404.html.twig');
        } elseif ($statusCode === 500) {
            return $this->render('error/500.html.twig');
        }
    }
}
