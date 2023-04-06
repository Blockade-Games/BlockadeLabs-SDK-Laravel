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

        // require the API key
        if(empty($this->apiKey)) {
            throw new \Exception('BlockadeLabs Client API Key is required. Please set it in your .env file.');
        }
    }

    public function getSkyboxStyles()
    {
        try {
            $response = Http::get($this->apiUrl . '/skybox/styles', [
                'api_key' => $this->apiKey
            ])->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Get Skybox Styles failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }

    public function generateSkybox($params)
    {
        try {
            $params['api_key'] = $this->apiKey;
            $response = Http::post($this->apiUrl . '/skybox', $params)->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Generate Skybox failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }

    public function getGenerators()
    {
        try {
            $response = Http::get($this->apiUrl . '/generators', [
                'api_key' => $this->apiKey
            ])->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Get Generators failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }

    public function generateImagine($params)
    {
        try {
            $params['api_key'] = $this->apiKey;
            $response = Http::asMultipart();

            // check if any of the params if of type file and attach it
            foreach ($params as $key => $param) {
                if(request()->file($key)) {
                    $image = request()->file($key);
                    $fileName = $image->getClientOriginalName();
                    $response = $response->attach($key, $image->getContent(), $fileName);
                    unset($params[$key]); // unset the file param, so it's not send again in the POST body
                }
            }

            $response = $response->post($this->apiUrl . '/imagine/requests', $params)
                ->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Generate Imagine failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }

    public function getImagineById($id)
    {
        try {
            $response = Http::get($this->apiUrl . '/imagine/requests/' . $id, [
                'api_key' => $this->apiKey
            ])->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Get Imagine by ID failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }

    public function getImagineByObfuscatedId($obfuscatedId)
    {
        try {
            $response = Http::get($this->apiUrl . '/imagine/requests/obfuscated-id/' . $obfuscatedId, [
                'api_key' => $this->apiKey
            ])->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Get Imagine by Obfuscated ID failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }

    public function getImagineHistory($params = [])
    {
        $params['api_key'] = $this->apiKey;

        try {
            $response = Http::get($this->apiUrl . '/imagine/myRequests', $params)->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Get Imagine History failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }

    public function cancelImagine($id)
    {
        try {
            $response = Http::delete($this->apiUrl . '/imagine/requests/' . $id, [
                'api_key' => $this->apiKey
            ])->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Cancel Imagine failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }

    public function cancelAllPendingImagines()
    {
        try {
            $response = Http::delete($this->apiUrl . '/imagine/requests/pending', [
                'api_key' => $this->apiKey
            ])->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Cancel All Pending Imagines failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }

    public function deleteImagine($id)
    {
        try {
            $response = Http::delete($this->apiUrl . '/imagine/deleteImagine/' . $id, [
                'api_key' => $this->apiKey
            ])->throw();
        } catch (RequestException $e) {
            $response = $e->response;
            \Log::error('Delete Imagine failed: ' . $e);
            \Log::error($response);
        }

        return $response->json();
    }
}
