<?php

namespace Phwoolcon\SmsAgent;

interface AdapterInterface
{

    public function getAdapterCode(): string;

    public function getRawResponse();

    public function getStatusCode();

    public function getStatusMessage(): string;

    public function send(string $mobile, string $content, array $extra = []): bool;
}
