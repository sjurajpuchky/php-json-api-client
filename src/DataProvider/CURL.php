<?php


namespace BABA\JSON\API\Client\DataProvider;

use BABA\JSON\API\Client\IDataProvider;

class CURL implements IDataProvider
{
    private $ignoreSSL;
    private $verbose;

    /**
     * CURL constructor.
     * @param bool $ignoreSSL
     */
    public function __construct(bool $ignoreSSL = true, bool $verbose = false)
    {
        $this->ignoreSSL = $ignoreSSL;
        $this->verbose = $verbose;
    }

    /**
     * @param $method
     * @param $url
     * @param $data
     * @param $headers
     * @param $withHeaders
     * @return array|bool|string
     */
    public function request($method, $url, $data = '', $headers = [], $withHeaders = false)
    {
        $ch = curl_init($url);

        switch ($method) {
            case self::METHOD_POST:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            case self::METHOD_GET:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                break;
            case self::METHOD_PUT:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_PUT, true);
                break;
            case self::METHOD_DELETE:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            case self::METHOD_PATCH:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
                break;
            case self::METHOD_HEAD:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_HEADER, true);
                break;
            default:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }

        if($this->ignoreSSL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        }

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if($this->verbose) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
        }

        if($withHeaders) {
            curl_setopt($ch,CURLOPT_HEADER, true);
            $response = curl_exec($ch);
            $headers = array();

            $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
            $content_text = substr($response, strpos($response, "\r\n\r\n"));

            foreach (explode("\r\n", $header_text) as $i => $line)
                if ($i === 0)
                    $headers['http_code'] = $line;
                else
                {
                    list ($key, $value) = explode(': ', $line);

                    $headers[$key] = $value;
                }

            return [$headers, $content_text];
        } else {
            $result = curl_exec($ch);
        }
        curl_close($ch);


        return $result;
    }
}