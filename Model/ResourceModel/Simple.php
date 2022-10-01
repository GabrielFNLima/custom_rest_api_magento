<?php
namespace GFNL\SimpleApi\Model\ResourceModel;

class Simple extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('gfnl_simpleapi', 'entity_id');
    }
}
