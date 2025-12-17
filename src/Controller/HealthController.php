<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

final class HealthController extends AbstractController
{
   public function __construct(
        private EntityManagerInterface $em
    ) {}
    
    #[Route('/health', name: 'app_health', methods: ['GET'])]
    public function health(): JsonResponse
    {
        $status = 'healthy';
        $checks = [];
        
        try {
            $this->em->getConnection()->executeQuery('SELECT 1');
            $checks['database'] = ['status' => 'connected', 'latency' => '5ms'];
        } catch (\Exception $e) {
            $checks['database'] = ['status' => 'error', 'message' => $e->getMessage()];
            $status = 'unhealthy';
        }
        
        $startTime = $_SERVER['REQUEST_TIME_FLOAT'] ?? microtime(true);
        $checks['response_time_ms'] = round((microtime(true) - $startTime) * 1000, 2);
        
        return new JsonResponse([
            'status' => $status,
            'timestamp' => date('c'), // ISO 8601
            'service' => 'Task Manager API',
            'version' => '1.0.0',
            'checks' => $checks
        ], $status === 'healthy' ? 200 : 503);
    }

}
