<?php

namespace Phwoolcon\SmsAgent;

use Exception;
use Phwoolcon\SmsAgent\Model\Logger;

trait AdapterTrait
{
    protected $config;
    protected $response;
    protected $statusCode;
    protected $statusMessage = '';

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getAdapterCode(): string
    {
        return $this->config['adapter_code'] ?? '';
    }

    public function getRawResponse()
    {
        return $this->response;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getStatusMessage(): string
    {
        return $this->statusMessage;
    }

    protected function logSms(string $mobile, string $content, array $extra = [])
    {
        /* @var AdapterInterface $this */
        return Logger::add($this, $mobile, $content, $extra);
    }

    abstract protected function realSend(string $mobile, string $content, array $extra = []): bool;

    public function send(string $mobile, string $content, array $extra = []): bool
    {
        $logger = $this->logSms($mobile, $content, $extra);
        try {
            $status = $this->realSend($mobile, $content, $extra);
            $logger->updateStatus($status);
        } catch (Exception $e) {
            $logger->updateStatus(false, $e);
            throw $e;
        }
        return $status;
    }
}
