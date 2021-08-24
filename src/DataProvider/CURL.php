<?php


namespace BABA\JSON\API\Client\DataProvider;

use BABA\JSON\API\Client\IDataProvider;

class CURL implements IDataProvider
{

    public function request($method, $url, $data = '', $headers = []): string
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
            case self::METHOD_HEAD:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "HEAD");
                curl_setopt($ch, CURLOPT_HEADER, true);
                break;
            default:
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        culr_close($ch);

        return $result;
    }
}