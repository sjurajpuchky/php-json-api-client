<?php


namespace BABA\JSON\API\Client;


interface IDataProvider
{
    const METHOD_POST = 1;
    const METHOD_GET = 0;
    const METHOD_PUT = 2;
    const METHOD_DELETE = 3;
    const METHOD_HEAD = 4;
    const METHOD_PATCH = 5;

    public function request($method, $url, $data = '', $headers = [], $withHeaders = false);
}