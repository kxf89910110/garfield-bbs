<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    public function translate($text)
    {
        // Instantiate the HTTP client
        $http = new Client;

        // Initialize configuration information
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        // If you don't configure Baidu translation, automatically use compatible Pinyin scheme
        if (empty($appid) || empty($key)) {
            return $this->pinyin($text);
        }

        // Generate sign according to the document
        // http://api.fanyi.baidu.com/api/trans/product/apidoc
        // appid+q+salt+ MD5 value of the key
        $sign = md5($appid. $text . $salt . $key);

        // Build request parameters
        $query = http_build_query([
            "q"     =>  $text,
            "from"  => "zh",
            "to"    => "en",
            "appid" => $appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);

        // Send an HTTP get request
        $response = $http->get($api.$query);

        $result = json_decode($response->getBody(), true);

        /**
        Get the result, if the request is successful, the result of dd($result) is as follows:

        array:3 [▼
            "from" => "zh"
            "to" => "en"
            "trans_result" => array:1 [▼
                0 => array:2 [▼
                    "src" => "XSS 安全漏洞"
                    "dst" => "XSS security vulnerability"
                ]
            ]
        ]

        **/

        // 尝试获取获取翻译结果
        if (isset($result['trans_result'][0]['dst'])) {
            return str_slug($result['trans_result'][0]['dst']);
        } else {
            // 如果百度翻译没有结果，使用拼音作为后备计划。
            return $this->pinyin($text);
        }
    }

    public function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));
    }
}
