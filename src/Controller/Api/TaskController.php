<?php

namespace App\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    #[Route('/api/task',name: 'api_task', methods: ['GET'])]
    public function index(): Response
    {
        $data = [
            'id'=> '1',
            'name'=>'Daria'
        ];
        return $this->json($data);
    }

}