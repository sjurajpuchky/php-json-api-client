<?php

namespace BABA\JSON\API\Client;

class JsonRestApiClient implements IApiClient
{
    /** @var IDataProvider */
    private $dataProviderClient;

    /**
     * JsonRestApiClient constructor.
     * @param IDataProvider $dataProviderClient
     */
    public function __construct(IDataProvider $dataProviderClient)
    {
        $this->dataProviderClient = $dataProviderClient;
    }

    public function get($url, $returnAsArray = false, $headers = [], $withHeaders = false)
    {
        if ($withHeaders) {
            list($headers,$result) = $this->dataProviderClient->request(IDataProvider::METHOD_GET, $url, '', $headers, $withHeaders);
            return [$headers, json_decode($result, $returnAsArray)];
        } else {
            $result = $this->dataProviderClient->request(IDataProvider::METHOD_GET, $url, '', $headers, $withHeaders);
            return json_decode($result, $returnAsArray);
        }
    }

    public function head($url, $returnAsArray = false, $headers = [])
    {
        return $this->dataProviderClient->request(IDataProvider::METHOD_HEAD, $url, '', $headers);
    }

    public function delete($url, $data = '', $returnAsArray = false, $headers = [])
    {
        $result = $this->dataProviderClient->request(IDataProvider::METHOD_DELETE, $url, $data, $headers);
        return json_decode($result, $returnAsArray);
    }

    public function put($url, $data = '', $returnAsArray = false, $headers = [])
    {
        $result = $this->dataProviderClient->request(IDataProvider::METHOD_PUT, $url, $data, $headers);
        return json_decode($result, $returnAsArray);
    }

    public function patch($url, $data = '', $returnAsArray = false, $headers = [])
    {
        $result = $this->dataProviderClient->request(IDataProvider::METHOD_PATCH, $url, $data, $headers);
        return json_decode($result, $returnAsArray);
    }

    public function post($url, $data = '', $returnAsArray = false, $headers = [])
    {
        $result = $this->dataProviderClient->request(IDataProvider::METHOD_POST, $url, $data, $headers);
        return json_decode($result, $returnAsArray);
    }
}