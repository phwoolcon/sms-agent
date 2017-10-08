<?php

namespace Phwoolcon\SmsAgent\Adapter;

use Phwoolcon\Http\Client;
use Phwoolcon\SmsAgent\AdapterInterface;
use Phwoolcon\SmsAgent\AdapterTrait;
use Phwoolcon\SmsAgent\Exception;

class SmsCn implements AdapterInterface
{
    use AdapterTrait;

    const URL = 'https://api.sms.cn/';

    protected function api(string $api, $data)
    {
        return Client::post(static::URL . $api, $data);
    }

    public function realSend(string $mobile, string $content, array $extra = []): bool
    {
        $this->response = $this->statusCode = null;
        $this->statusMessage = '';
        $response = $this->api('sms', [
            'ac'      => 'send',
            'uid'     => $this->config['username'] ?? '',
            'pwd'     => $this->config['password_hash'] ?? '',
            'mobile'  => $mobile,
            'content' => $content,
        ]);
        $returnData = json_decode($response, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new Exception('Bad response from sms.cn: ' . json_last_error_msg() . ', response content: "' .
                $response . '"', json_last_error());
        }
        $this->response = $returnData;
        $this->statusCode = $returnData['stat'] ?? null;
        $this->statusMessage = $returnData['message'] ?? '';
        return $this->statusCode == 100;
    }
}
