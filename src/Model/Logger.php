<?php

namespace Phwoolcon\SmsAgent\Model;

use Exception;
use Phwoolcon\Model;
use Phwoolcon\SmsAgent\AdapterInterface;

class Logger extends Model
{
    use \SmsLogModelTrait;

    protected $_table = 'sms_log';
    protected $_jsonFields = ['extra_data'];
    /**
     * @var AdapterInterface
     */
    protected $adapterInstance;

    public static function add(AdapterInterface $adapter, string $mobile, string $content, array $extra = []): Logger
    {
        $logger = new static;
        $logger->setAdapterInstance($adapter);
        $logger->addData([
            'adapter'    => $adapter->getAdapterCode(),
            'mobile'     => $mobile,
            'content'    => $content,
            'extra_data' => $extra,
        ]);
        $logger->save();
        return $logger;
    }

    /**
     * @param AdapterInterface $adapterInstance
     * @return Logger
     */
    public function setAdapterInstance(AdapterInterface $adapterInstance): Logger
    {
        $this->adapterInstance = $adapterInstance;
        return $this;
    }

    public function updateStatus($status, Exception $e = null): Logger
    {
        $this->setStatus($status ? 1 : 0);
        if ($adapter = $this->adapterInstance) {
            $this->setStatusCode($adapter->getStatusCode());
            $this->setStatusMessage($adapter->getStatusMessage());
            $extraData = $this->getExtraData() ?: [];
            $extraData['response'] = $adapter->getRawResponse();
            $this->setExtraData($extraData);
        }
        $e and $this->setException(get_class($e) . "\n" . $e->__toString());
        $this->save();
        return $this;
    }
}
