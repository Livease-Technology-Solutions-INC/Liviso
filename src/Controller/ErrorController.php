<?php

namespace App\Controller;

use Throwable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ErrorController extends AbstractController
{
    public function showException(Request $request, DebugLoggerInterface $logger = null): Response
    {
        $exception = $request->get('exception');

        if ($exception && method_exists($exception, 'getStatusCode') && $exception->getStatusCode() === 500 && $this->isDatabaseConnectionIssue($exception)) {
            return $this->render('error/500.html.twig');
        } else {
            return $this->render('error/404.html.twig', [
                'exception' => $exception
            ]);
        }
    }

    private function isDatabaseConnectionIssue($exception): bool
    {
        $message = $exception->getMessage();
        return stripos($message, 'SQLSTATE[HY000] [2002] No connection could be made') !== false;
    }
}
