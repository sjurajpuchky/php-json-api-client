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
     * @param bool $withHeaders
     * @param int|null $timeout
     * @return array|bool|string
     */
    public function request($method, $url, $data = '', $headers = [], $withHeaders = false, $timeout = null)
    {
        $ch = curl_init($url);

        switch ($method) {
            case self::METHOD_POST:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            case self::METHOD_GET:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                break;
            case self::METHOD_PUT:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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

        if ($timeout) {
            // Connection timeout (seconds)
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

            // Overall timeout (seconds)
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        }

        if ($this->ignoreSSL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        }

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $prepared_headers = [];
        foreach($headers as $name => $value) {
            $prepared_headers[] = $name.': '.$value;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $prepared_headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        if($this->verbose) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
        }

        if($withHeaders) {
            $headers =  [];
            curl_setopt($ch, CURLOPT_HEADERFUNCTION,
                function($curl, $header) use (&$headers)
                {
                    $len = strlen($header);
                    $header = explode(':', $header, 2);
                    if (count($header) < 2)
                        return $len;

                    $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                    return $len;
                }
            );
            $content_text = curl_exec($ch);
            return [$headers, $content_text];
        } else {
            $result = curl_exec($ch);
        }
        curl_close($ch);


        return $result;
    }
}
