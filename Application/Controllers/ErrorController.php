<?php

namespace Controllers;

use Libraries\Core\Controller;

class ErrorController extends Controller
{

    /**
     * 403 Forbidden
     */
    public function error403()
    {
        header('HTTP/1.0 403 Forbidden', true, 403);
        $this->getView()->render('Templates/Errors/error403');
    }

    /**
     * 404 Not Found
     */
    public function error404()
    {
        header('HTTP/1.0 404 Not Found', true, 404);
        $this->getView()->render('Templates/Errors/error404');
    }

    /**
     * 500 Internal Server Error
     */
    public function error500()
    {
        header('HTTP/1.0 500 Internal Server Error', true, 500);
        $this->getView()->render('Templates/Errors/error500', ['serverAdmin' => getenv('SERVER_ADMIN')]);
    }

    /**
     * PDOException
     * @param int $errorCode
     */
    public function connectionError()
    {
        header('HTTP/1.0 503 Service Unavailable', true, 503);
        $this->getView()->render('Templates/Errors/connectionError', ['serverAdmin' => getenv('SERVER_ADMIN')]);
    }

    /**
     * Error page
     * @param string $title
     * @param string $message
     */
    public function error(string $title, string $message, int $responseCode = 500, string $responseMessage = 'Internal Server Error')
    {
        $data = [
            'title' => $title,
            'message' => $message,
            'serverAdmin' => getenv('SERVER_ADMIN'),
            'errorCode' => $responseCode
        ];

        header('HTTP/1.0 ' . $responseCode . ' ' . $responseMessage, true, $responseCode);
        $this->getView()->render('Templates/Errors/error', $data);
    }
    
}
