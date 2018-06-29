<?php

namespace Phwoolcon\SmsAgent\Adapter;

use Phwoolcon\Http\Client;
use Phwoolcon\Log;
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
        $response = $this->api('sms/', [
            'ac'      => 'send',
            'encode'  => 'utf8',
            'uid'     => $this->config['username'] ?? '',
            'pwd'     => $this->config['password_hash'] ?? '',
            'mobile'  => $mobile,
            'content' => $content,
        ]);
        $this->response = $response;
        $returnData = json_decode($response, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new Exception('Bad response from sms.cn: ' . json_last_error_msg() . ', response content: "' .
                $response . '"', json_last_error());
        }
        $this->statusCode = $returnData['stat'] ?? null;
        $this->statusMessage = $this->filterReturnMessage($returnData);
        return $this->statusCode == 100;
    }

    protected function filterReturnMessage($returnData)
    {
        /**
         * 100        发送成功　　    o
         * 101        验证失败　　    x
         * 102        短信不足　　    x
         * 103        操作失败　　    o
         * 104        非法字符　　    x
         * 105        内容过多　　    x
         * 106        号码过多　　    x
         * 107        频率过快　　    o
         * 108        号码内容空　    o
         * 109        账号冻结　　    x
         * 112        号码错误　　    o
         * 113        定时出错　　    x
         * 116        禁止接口发送    x
         * 117        绑定IP不正确   x
         * 161        未添加短信模板   x
         * 162        模板格式不正确   x
         * 163        模板ID不正确   x
         * 164        全文模板不匹配   x
         */
        $message = $returnData['message'] ?? '';
        $transparentCodes = [100, 103, 107, 108, 112,];
        if (in_array($returnData['stat'] ?? null, $transparentCodes)) {
            return $message;
        } else {
            Log::error(
                'sms.cn error response: ' . var_export($returnData, true) .
                '; request: ' . var_export(Client::getInstance()->getLastRequest(), true)
            );
            return __('Internal Server Error');
        }
    }
}
