<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskNotFoundException extends NotFoundHttpException
{
    public function __construct(string $message = 'Task nie został znaleziony')
    {
        parent::__construct($message);
    }
}
