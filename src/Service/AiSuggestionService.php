<?php

namespace App\Service;

final class AiSuggestionService
{
    public function __construct(private string $apiKey) {}

    public function suggest(?string $title = null, ?string $description = null): array
    {
        // 1. sugeruj tytuł
        if (!$title && $description) {
            $prompt = $this->buildTitlePrompt($description);
            $response = $this->callGeminiApi($prompt);
            return $this->parseResponse($response);
        }

        // 2. sugeruj opis
        if ($title && !$description) {
            $prompt = $this->buildDescriptionPrompt($title);
            $response = $this->callGeminiApi($prompt);
            return $this->parseResponse($response);
        }

        // 3. sugeruj ulepszenie (poprawiony tytuł LUB opis)
        if ($title && $description) {
            $prompt = $this->buildImprovementPrompt($title, $description);
            $response = $this->callGeminiApi($prompt);
            return $this->parseResponse($response);
        }

        return [];
    }

    private function buildTitlePrompt(string $description): string
    {
        return "Jesteś Product Ownerem. Na podstawie opisu zadania zaproponuj 3 tytuły.\n\n"
            . "Opis: $description\n\n"
            . "Zasady:\n"
            . "- Każdy tytuł max 8 słów\n"
            . "- Tylko konkretne nazwy, bez opisów\n"
            . "- Zwróć WYŁĄCZNIE 3 linie tekstu, każda z jedną nazwą\n"
            . "- Bez numeracji i wypunktowania";
    }

    private function buildDescriptionPrompt(string $title): string
    {
        return "Jesteś Product Ownerem. Na podstawie tytułu zadania zaproponuj 3 opisy.\n\n"
            . "Tytuł: $title\n\n"
            . "Zasady:\n"
            . "- Każdy opis max 2 zdania\n"
            . "- Konkretne, merytoryczne\n"
            . "- Zwróć WYŁĄCZNIE 3 linie tekstu, każda z jednym opisem\n"
            . "- Bez numeracji i wypunktowania";
    }

    private function buildImprovementPrompt(string $title, string $description): string
    {
        return "Jesteś Product Ownerem. Masz zadanie:\n"
            . "Tytuł: $title\n"
            . "Opis: $description\n\n"
            . "Zaproponuj 3 ulepszone wersje (tytuł i opis).\n"
            . "Format każdej linii: TYTUŁ | OPIS\n"
            . "Zwróć WYŁĄCZNIE 3 linie w tym formacie, bez niczego więcej.";
    }

    private function parseResponse(string $text): array
    {
        $result = explode("\n", $text);
        $result = array_filter($result, function($line) {
            return !empty(trim($line));
        });
        $result = array_values($result);
        return $result;
    }

    private function callGeminiApi(string $prompt): string
    {
        // Tutaj implementacja wywołania API Gemini z wykorzystaniem $this->apiKey
        // i zwrócenie sugestii na podstawie opisu zadania
        $client = \Gemini::client($this->apiKey);

        $result = $client->generativeModel('gemini-2.5-flash')->generateContent($prompt);

        return $result->text();
    }
}
