<?php

namespace Phwoolcon\SmsAgent\Adapter;

use Phwoolcon\SmsAgent\AdapterInterface;
use Phwoolcon\SmsAgent\AdapterTrait;

class SelfHostedAgent implements AdapterInterface
{
    use AdapterTrait;

    public function realSend(string $mobile, string $content, array $extra = []): bool
    {
        // TODO: Implement realSend() method.
        return true;
    }
}
