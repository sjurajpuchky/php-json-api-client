<?php


namespace BABA\JSON\API\Client;


interface IApiClient
{
    public function get($url, $returnAsArray = false, $headers = []);

    public function head($url, $returnAsArray = false, $headers = []);

    public function delete($url, $data = '', $returnAsArray = false, $headers = []);

    public function put($url, $data = '', $returnAsArray = false, $headers = []);

    public function post($url, $data = '', $returnAsArray = false, $headers = []);
}