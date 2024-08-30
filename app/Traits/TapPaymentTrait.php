<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait TapPaymentTrait
{
    protected $baseUri;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUri = 'https://api.tap.company/v2/';
        $this->secretKey = config('services.tap.secret');
    }

    private function makeRequest(string $method, string $endpoint, array $data = [])
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->{$method}($this->baseUri . $endpoint, $data);

        return $response->json();
    }

    public function createCharge(array $data)
    {
        return $this->makeRequest('post', 'charges', $data);
    }

    public function retrieveCharge(string $tapId)
    {
        return $this->makeRequest('get', 'charges/' . $tapId);
    }
}
