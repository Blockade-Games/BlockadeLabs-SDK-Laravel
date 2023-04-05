<?php

namespace BlockadeLabs\SDK;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class SDKClient
{
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('blockadelabs.api_url');
        $this->apiKey = config('blockadelabs.api_key');

        if(empty($this->apiKey)) {
            throw new \Exception('BlockadeLabs Client API Key is required. Please set it in your .env file.');
        }
    }

    public function getSkyboxStyles()
    {
        try {
            $response = Http::get($this->apiUrl . '/skybox/styles?api_key=' . $this->apiKey)->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Get Skybox Styles failed: ' . $e);
            \Log::error($e->response);
        }

        return $response->json();
    }

    public function generateSkybox($params)
    {
        try {
            $response = Http::post($this->apiUrl . '/skybox?api_key=' . $this->apiKey, $params)->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Generate Skybox failed: ' . $e);
            \Log::error($e->response);
        }

        return $response->json();
    }

    public function getGenerators()
    {
        try {
            $response = Http::get($this->apiUrl . '/generators?api_key=' . $this->apiKey)->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Get Generators failed: ' . $e);
            \Log::error($e->response);
        }

        return $response->json();
    }

    public function generateImagine($params, $files = [])
    {
        try {
            $response = Http::asMultipart();

            foreach ($params as $key => $param) {
                if(request()->file($key)) {
                    $image = request()->file($key);
                    $fileName = $image->getClientOriginalName();
                    $response = $response->attach($key, $image->getContent(), $fileName);
                    unset($params[$key]);
                }
            }

            $response = $response->post($this->apiUrl . '/imagine/requests?api_key=' . $this->apiKey, $params)
                ->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Generate Imagine failed: ' . $e);
            \Log::error($e->response);
        }

        return $response->json();
    }
}
