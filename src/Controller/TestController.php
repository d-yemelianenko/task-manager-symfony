<?php

namespace App\Controller;

use App\Service\AiSuggestionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test-suggest', name: 'test_suggest')]
    public function testSuggest(AiSuggestionService $aiService): Response
    {
        $suggestions = $aiService->suggest(description: 'Przygotować raport kwartalny');
        dd($suggestions);
    }
}
