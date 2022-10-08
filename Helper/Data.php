<?php
namespace GFNL\SimpleApi\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function __construct(
        \Magento\Framework\Serialize\Serializer\Json $jsonSerializer
    ) {
        $this->_jsonSerializer = $jsonSerializer;
    }

    public function encodeArray($array)
    {
        return $this->_jsonSerializer->serialize($array);
    }
    public function decodeArray($array)
    {
        return $this->_jsonSerializer->unserialize($array);
    }
}

