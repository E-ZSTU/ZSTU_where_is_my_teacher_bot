<?php
declare(strict_types = 1);

namespace ZSTU\RozkladClient\V1;

use GuzzleHttp\Client as HttpClient;

/**
 * Class Client
 *
 * @package ZSTU\RozkladClient\V1
 */
class Client
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Client constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Teacher\Client
     */
    public function teacher(): Teacher\Client
    {
        return new Teacher\Client($this->httpClient);
    }
}
