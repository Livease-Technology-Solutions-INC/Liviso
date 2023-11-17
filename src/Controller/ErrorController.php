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
use Doctrine\DBAL\Exception\ConnectionException;

class ErrorController extends AbstractController
{
    public function showException(Request $request, DebugLoggerInterface $logger = null): Response
    {
        $exception = $request->get('exception');

        if ($exception && $this->isDatabaseConnectionIssue($exception)) {
            return $this->render('error/database_connection_issue.html.twig', [
                'exception' => $exception
            ]);
        } else {
            return $this->render('error/404.html.twig', [
                'exception' => $exception
            ]);
        }
    }

    private function isDatabaseConnectionIssue($exception): bool
    {
        $pdoErrorCodes = [2002, 2005, 1049, 2054, 1370, 1429];
    
        if ($exception instanceof \PDOException) {
            $errorCode = (int) $exception->getCode();
    
            // Debug output
            var_dump($errorCode);
    
            // Check if the error code is in the array of PDO error codes
            return in_array($errorCode, $pdoErrorCodes);
        }
    
        return false;
    }
    
}
