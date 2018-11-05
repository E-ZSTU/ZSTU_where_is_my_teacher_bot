<?php
declare(strict_types = 1);

namespace ZSTU\RozkladClient\V1\Teacher;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use ZSTU\RozkladClient\V1\Teacher\ResponseData\ScheduleResponseData;
use ZSTU\RozkladClient\V1\Teacher\ResponseData\SearchResponseData;

/**
 * Class Client
 *
 * @package ZSTU\RozkladClient\V1\Teacher
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
     * @param string $name
     *
     * @return SearchResponseData
     */
    public function search(string $name): SearchResponseData
    {
        $response = $this->httpClient->request('GET', '/teacher-search', [
            RequestOptions::QUERY => ['name' => $name],
        ]);
        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        return new SearchResponseData($jsonResponse);
    }

    /**
     * @param int $id
     *
     * @return ScheduleResponseData
     */
    public function schedule(int $id): ScheduleResponseData
    {
        $response = $this->httpClient->request('GET', "/teacher-schedule/$id");

        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        return new ScheduleResponseData($jsonResponse);
    }
}
