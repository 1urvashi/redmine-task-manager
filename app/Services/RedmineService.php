<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RedmineService
{
    protected $apiUrl;
    protected $apiKey;

    // public function __construct()
    // {
    //     $this->apiUrl = config('app.redmine_api_url');
    //     $this->apiKey = config('app.redmine_api_key');
    // }

    public function __construct()
    {
        if (config('app.redmine_use_docker')) {
            $this->apiUrl = config('app.redmine_docker_url');
        } else {
            $this->apiUrl = config('app.redmine_api_url');
        }

        $this->apiKey = config('app.redmine_api_key');
    }

    public function getIssues()
    {
        $response = Http::withHeaders([
            'X-Redmine-API-Key' => $this->apiKey,
        ])->get("{$this->apiUrl}/issues.json");

        return $response->json()['issues'] ?? [];
    }

    // Add more methods as needed to interact with Redmine API
}
