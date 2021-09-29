<?php

namespace WpPhpRequestGo;

use GuzzleHttp\Client;
use Throwable;

class PhpRequestGo
{


    /**
     * GO 访问域名
     * @var string
     */
    private static string $endpoint = 'http://127.0.0.1:9501';

    public function connectGo(string $api, array $params, string $method)
    {
        try {
            $method = strtoupper($method);
            // 发送数据
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => self::$endpoint,
                // You can set any number of default request options.
                'timeout' => 5.0,
            ]);

            $res = $client->request($method, $api, [
                'body' => self::arrayToJson($params),
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
            return json_decode($res->getBody()->getContents(), true);
        } catch (Throwable $e) {
            return ['code' => 1, 'msg' => $e->getMessage(), 'status' => false, 'data' => []];

        }
    }

    private static function arrayToJson(array $res)
    {
        return json_encode($res, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
    }
}
