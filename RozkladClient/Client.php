<?php
declare(strict_types = 1);

namespace ZSTU\RozkladClient;

use GuzzleHttp\Client as HttpClient;

/**
 * Class Client
 *
 * @package ZSTU\RozkladClient
 */
class Client
{
    /**
     * @var HttpClient|null
     */
    private $httpClient;

    /**
     * Client constructor.
     *
     * @param HttpClient|null $httpClient
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new HttpClient([
                'base_uri' => 'https://rozklad-zstu-api.herokuapp.com',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],]);
    }

    /**
     * @return V1\Client
     */
    public function v1(): V1\Client
    {
        return new V1\Client($this->httpClient);
    }
}
